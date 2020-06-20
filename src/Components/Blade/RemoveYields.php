<?php


namespace App\Components\Blade;

/**
 * Class RemoveYields
 * @package App\Components\Blade
 */
class RemoveYields implements BladeDirectiveInterface
{

    /**
     * @return mixed|string
     */
    public function getDirectiveRegexPattern()
    {
        return '/@yield\((?P<yield_name>.*)\)/';
    }

    /**
     * @param string $template
     * @return mixed|string|string[]|null
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function () {
            return null;
        }, $template);
    }
}
