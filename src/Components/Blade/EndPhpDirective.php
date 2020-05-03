<?php


namespace App\Components\Blade;

/**
 * Class EndPhpDirective
 * @package Blade
 */
class EndPhpDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endphp/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '; ?>';
        }, $template);
    }
}
