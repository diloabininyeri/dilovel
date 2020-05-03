<?php

namespace App\Components\Blade;

/**
 * Interface BladeDirectiveInterface
 */
interface BladeDirectiveInterface
{

    /**
     * @return mixed
     */
    public function getDirectiveRegexPattern();
    /**
     * @param string $template
     * @return mixed
     */
    public function replaceTemplate(string $template);
}
