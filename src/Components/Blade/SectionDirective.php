<?php


namespace App\Components\Blade;

class SectionDirective implements BladeDirectiveInterface
{
    public function getDirectiveRegexPattern()
    {
        return '/@section\((?P<yield_name>.*)\)\n*(?P<html_content>.*)\n*@endsection/sU';
    }

    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), static function ($find) {
            return $find['html_content'];
        }, $template);
    }
}
