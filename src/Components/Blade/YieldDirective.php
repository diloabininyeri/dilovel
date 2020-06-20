<?php


namespace App\Components\Blade;

/**
 * Class YieldDirective
 * @package App\Components\Blade
 */
class YieldDirective implements BladeDirectiveInterface
{
    /**
     * @var string
     */
    private string  $yieldName;

    /**
     * @var string|null
     */
    private ?string $template=null;

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
        $this->template=$template;
        preg_replace_callback($this->getDirectiveRegexPattern(), function ($find) {
            $this->yieldName = trim($find['yield_name'], '\'');
            $this->template = $this->replaceYieldWithSection($this->template);
        }, $template);

        return $this->template;
    }

    /**
     * @param string $template
     * @return string
     */
    private function replaceYieldWithSection(string $template): string
    {
        echo $this->yieldName;
        $regex = "/@section\(('{$this->yieldName}')\)\n*(?P<html_content>.*)\n*@endsection/sU";
        return preg_replace_callback($regex, function ($find) {
            return $find['html_content'];
        }, $template);
    }
}
