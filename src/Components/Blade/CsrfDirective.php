<?php


namespace App\Components\Blade;

use App\Components\Enums\CrsfEnum;

class CsrfDirective implements BladeDirectiveInterface
{
    public function getDirectiveRegexPattern()
    {
        // TODO: Implement getDirectiveRegexPattern() method.
    }

    public function replaceTemplate(string $template)
    {
        $tokenName=CrsfEnum::CSRF_INPUT_NAME;
        return str_replace('@csrf', '<input type="hidden" value="{{csrf()->generateToken()}}" name="'.$tokenName.'"/>', $template);
    }
}
