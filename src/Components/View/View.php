<?php


namespace App\Components\View;

use App\Components\Blade\Blade;

/**
 * Class View
 * @package App\Components\View
 */
class View
{


    /**
     * @param $blade
     * @return mixed
     */
    public function render($blade)
    {
        $bladeClass = new Blade();
        return $bladeClass->render($blade);
    }
}