<?php


namespace App\Components\Blade;

class EndforeachDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@endforeach/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return '<?php endforeach; ?>';
        }, $template);
    }
}
