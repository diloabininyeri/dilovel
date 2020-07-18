<?php


namespace App\Interfaces;

use App\Components\Http\Request;

/**
 * Interface ValidateLengthInterface
 * @package App\Interfaces
 */
interface ValidateLengthInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @param int $length
     * @return bool
     */
    public function valid(Request $request, string $input, int $length): bool;

    /**
     * @return string
     */
    public function message():string ;
}
