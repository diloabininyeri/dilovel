<?php


namespace App\Components\Blade;

class IncludeDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/@include\((.*)\)/';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            $view = trim($find[1], "'");
            $viewPath = sprintf('src/Views/%s.blade.php', str_replace('.', '/', $view));
            return file_get_contents($viewPath);
        }, $template);
    }
}
