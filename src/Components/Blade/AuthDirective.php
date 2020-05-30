<?php


namespace App\Components\Blade;

class AuthDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($f) {
            return '<?php if(user()->check()) :?>';
        }, $template);
    }

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@auth(.*)/';
    }
}
