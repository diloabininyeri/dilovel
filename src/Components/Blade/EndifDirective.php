<?php

namespace App\Components\Blade;

/**
 * Class EndifDirective
 * @package Blade
 */
class EndifDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endif/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return  preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '<?php endif;?>';
        }, $template);
    }
}
