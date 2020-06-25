<?php


namespace App\Components\Blade;

class CsrfDirective implements BladeDirectiveInterface
{
    public function getDirectiveRegexPattern()
    {
        // TODO: Implement getDirectiveRegexPattern() method.
    }

    public function replaceTemplate(string $template)
    {
        return str_replace('@csrf', '<input type="hidden" value="{{csrf()->generateToken()}}" name="_token"/>', $template);
    }
}
