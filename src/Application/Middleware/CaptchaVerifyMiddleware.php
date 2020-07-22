<?php


namespace App\Application\Middleware;

use App\Components\Captcha;
use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Components\Route\Redirect\Redirect;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class CaptchaVerifyMiddleware
 * @package App\Application\Middleware
 */
class CaptchaVerifyMiddleware implements MiddlewareInterface
{
    /**
     * @param Closure $next
     * @param Request $request
     * @return Redirect|mixed
     */
    public function handle(Closure $next, Request $request)
    {
        if ((new Captcha())->verify($request->post('_captcha'))) {
            return $next($request);
        }
        return  redirect()->back()->withOldInput()->withFormError(Lang::get('captcha.message'));
    }
}
