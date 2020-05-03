<?php


namespace App\Components\Blade;

class ElseIfDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@elseif(.*)/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return  preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '<?php elseif('.$find[1].') : ?>';
        }, $template);
    }
}
