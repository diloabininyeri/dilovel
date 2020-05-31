<?php


namespace App\Components\Blade;

/**
 * Class CustomDirective
 * @package App\Components\Blade
 */
class CustomDirective implements BladeDirectiveInterface
{
    /**
     * @return mixed|string
     */
    public function getDirectiveRegexPattern()
    {
        return  '/@([\w]+[\d]?+)\((.*)\)/m';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return  preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            if (is_callable($find[1])) {
                return sprintf('<?php echo %s(%s); ?>', $find[1], $find[2]);
            }
            return $find[0];
        }, $template);
    }
}
