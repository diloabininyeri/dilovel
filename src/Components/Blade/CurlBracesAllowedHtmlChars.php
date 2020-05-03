<?php


namespace App\Components\Blade;

class CurlBracesAllowedHtmlChars implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/{!!(.*)!!}/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return '<?php echo' . $find[1] . '; ?>';
        }, $template);
    }
}
