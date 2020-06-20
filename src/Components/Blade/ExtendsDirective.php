<?php


namespace App\Components\Blade;

/**
 * Class ExtendsDirective
 * @package App\Components\Blade
 */
class ExtendsDirective implements BladeDirectiveInterface
{

    /**
     * @return mixed|string
     */
    public function getDirectiveRegexPattern()
    {
        return '/@extends\((?P<view>.*)\)/';
    }

    /**
     * @param string $template
     * @return mixed|string|string[]|null
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            $viewName = trim($find['view'], "'");
            $viewName=str_replace('.', '/', $viewName);
            return file_get_contents("src/Views/$viewName.blade.php");
        }, $template);
    }
}
