<?php


namespace App\Components\Blade;

/**
 * Class Compress
 * @package Blade
 */
class CompressBlade implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return str_replace(array("\n\n", '    '), '', $template);
    }
}
