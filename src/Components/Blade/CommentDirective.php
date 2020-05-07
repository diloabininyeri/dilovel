<?php


namespace App\Components\Blade;

/**
 * Class CommentDirective
 * @package App\Components\Blade
 */
class CommentDirective implements BladeDirectiveInterface
{

    /**
     * @return mixed|string
     */
    public function getDirectiveRegexPattern()
    {
        return '/{{--(.*?)--}}/ms';
    }

    /**
     * @param string $template
     * @return mixed|string|string[]|null
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '<?php /*' . $find[1] . '*/ ?>';
        }, $template);
    }
}
