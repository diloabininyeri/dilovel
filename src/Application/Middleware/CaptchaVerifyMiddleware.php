<?php


namespace App\Application\Middleware;

use App\Components\Captcha;
use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\MiddlewareInterface;
use Closure;

class CaptchaVerifyMiddleware implements MiddlewareInterface
{
    public function handle(Closure $next, Request $request)
    {
        if ((new Captcha())->verify($request->post('_captcha'))) {
            return $next($request);
        }
        return  redirect()->back()->withError('form_validation_error', Lang::get('captcha.message'));
    }
}
