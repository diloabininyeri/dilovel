<?php


namespace App\Components\Blade;

class JsEscapeDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@{{(.*)}}/sU';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '{{' . $find[1] . '}}';
        }, $template);
    }
}
