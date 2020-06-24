<?php


namespace App\Application\Middleware\Abstracts;

 use App\Components\Csrf\CsrfGuard;
 use App\Components\Http\Request;
 use App\Components\Http\Url;

 abstract class AbstractCsrfTokenMiddleware
 {
     /**
      * @param Request $request
      * @return bool
      */
     final protected function isCanPass(Request $request): bool
     {
         if (in_array($request->method(), $this->methods, true)) {
             return $this->isPathExcept() || $this->validationToken($request);
         }
         return true;
     }

     /**
      * @param Request $request
      * @return bool
      */
     final protected function validationToken(Request $request): bool
     {
         return (new CsrfGuard())->validateToken($request->post('_token') ?? 'csrf');
     }


     /**
      * @return bool
      */
     final protected function isPathExcept(): bool
     {
         $path=(new Url())->pathWithTrim();
         $trimmedExcepts=array_map(fn ($item) => trim($item, '/'), $this->except);
         return in_array($path, $trimmedExcepts, true);
     }
 }
