<?php


namespace App\Components\Traits;

use App\Application\Middleware;
use App\Components\Http\Request;

trait RequestValidation
{

    /**
     * @param Request $request
     * @param array $rules
     * @return bool|void
     */
    final public function validate(array $rules, Request $request=null)
    {
        $request=$request ?: new Request();
        $inputs = $request->check($rules)->validate();

        if ($inputs->isFailed()) {
            return exit(redirect()
                ->back()
                ->withFormError($inputs->getErrors())
                ->withOldInput()
                ->header());
        }
        return true;
    }

    /**
     * @param string ...$middleware
     * @return bool|void
     */
    final public function middleware(string ...$middleware)
    {
        $union=new Middleware(...$middleware);
        $union->call(new Request());
        if (!$union->isInstanceOfRequest()) {
            return exit($union->getResponse());
        }
        return true;
    }
}
