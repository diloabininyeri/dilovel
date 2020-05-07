<?php

namespace App\Components\Blade;

class CurlBracesDirective implements BladeDirectiveInterface
{

    /**
     * @inheritDoc
     */
    public function getDirectiveRegexPattern()
    {
        return '/.?{{(.*)}}/sU';
    }

    /**
     * @inheritDoc
     */
    public function replaceTemplate(string $template)
    {
        return preg_replace_callback($this->getDirectiveRegexPattern(), function ($find) {
            $firstLetter=$this->getFirstLetter($find);

            if ($firstLetter === '@') {
                return $find[0];
            }

            if ($firstLetter !== ' ') {
                return $firstLetter . '<?php echo htmlspecialchars(' . $find[1] . ');?>';
            }

            return '<?php echo htmlspecialchars(' . $find[1] . ');?>';
        }, $template);
    }

    /**
     * @param $find
     * @return mixed
     */
    private function getFirstLetter($find)
    {
        return $find[0][0];
    }
}
