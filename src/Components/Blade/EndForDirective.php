<?php


namespace App\Components\Blade;

class EndForDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endfor$/m';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '<?php endfor; ?>';
        }, $template);
    }
}
