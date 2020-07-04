<?php


namespace App\Application\Middleware\Abstracts;

use App\Components\Csrf\CsrfGuard;
use App\Components\Enums\CrsfEnum;
use App\Components\Http\Request;
use App\Components\Http\Response\Response;
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
        return (new CsrfGuard())->validateToken($request->post(CrsfEnum::CSRF_INPUT_NAME) ?? 'csrf');
    }


    /**
     * @return bool
     */
    final protected function isPathExcept(): bool
    {
        $path = (new Url())->pathWithTrim();
        $trimmedExcepts = array_map(fn ($item) => trim($item, '/'), $this->except);
        return in_array($path, $trimmedExcepts, true);
    }

    /**
     * @param Request $request
     * @return false|string|null
     */
    final protected function returnError(Request $request)
    {
        if ($request->isAjax()) {
            return (new Response())->setStatus(500)->toJson(['status' => false, 'error' => ' csrf must be verify']);
        }
        http_response_code(500);
        return view('errors.csrf', ['error' => ' csrf must be verify']);
    }
}
