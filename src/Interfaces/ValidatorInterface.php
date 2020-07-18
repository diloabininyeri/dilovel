<?php


namespace App\Interfaces;

use App\Components\Http\Request;

/**
 * Interface ValidatorInterface
 * @package App\Interfaces
 */
interface ValidatorInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool;

    /**
     * @return string
     */
    public function message():string ;
}
