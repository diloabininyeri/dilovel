<?php


namespace App\Components\Blade;

class ElseDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@else$/m';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return  preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '<?php else: ?>';
        }, $template);
    }
}
