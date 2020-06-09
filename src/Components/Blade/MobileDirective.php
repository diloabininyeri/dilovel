<?php


namespace App\Components\Blade;

class MobileDirective implements BladeDirectiveInterface
{
    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($f) {
            return '<?php if(request()->isMobile()):?>';
        }, $template);
    }

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@mobile(.*)/';
    }
}
