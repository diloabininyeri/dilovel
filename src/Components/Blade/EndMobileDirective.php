<?php


namespace App\Components\Blade;

class EndMobileDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endmobile/';
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
