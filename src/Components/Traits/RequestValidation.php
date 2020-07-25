<?php


namespace App\Components\Traits;

use App\Application\Middleware;
use App\Components\Http\Request;
use App\Components\Http\SingletonRequest;

/**
 * Trait RequestValidation
 * @package App\Components\Traits
 */
trait RequestValidation
{

    /**
     * @return Request
     */
    final public function getRequest(): Request
    {
        return SingletonRequest::get();
    }
    /**
     * @param Request $request
     * @param array $rules
     * @return bool|void
     */
    final public function validate(array $rules, Request $request=null)
    {
        $request=$request ?: $this->getRequest();
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
        $union->call(Request::getInstance());
        if (!$union->isInstanceOfRequest()) {
            return exit($union->getResponse());
        }
        return true;
    }
}
