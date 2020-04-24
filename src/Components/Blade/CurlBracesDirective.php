<?php

namespace App\Components\Blade;


class CurlBracesDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
       return '/[^@]{{(.*)}}/sU';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {

            return '<?php echo ' . e($find[1]) . ';?>';
        }, $template);

    }
}