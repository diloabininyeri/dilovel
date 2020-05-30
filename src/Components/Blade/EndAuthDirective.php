<?php


namespace App\Components\Blade;

class EndAuthDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endauth/m';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '<?php endif; ?>';
        }, $template);
    }
}
