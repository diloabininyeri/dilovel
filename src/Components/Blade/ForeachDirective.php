<?php


namespace App\Components\Blade;

class ForeachDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@foreach(.*)/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            print_r($find);
            return '<?php foreach' . $find[1] . ' :?>';
        }, $template);
    }
}
