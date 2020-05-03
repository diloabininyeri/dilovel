<?php


namespace App\Components\Blade;

/**
 * Class ForDirective
 * @package Blade
 */
class ForDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@for(.*)/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '<?php for' . $find[1] . ' :?>';
        }, $template);
    }
}
