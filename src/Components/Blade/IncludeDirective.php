<?php


namespace App\Components\Blade;

class IncludeDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@include(.*)/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '<php include'.$find[1].'; ?>';
        }, $template);
    }
}
