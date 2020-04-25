<?php


namespace App\interfaces;


use App\Http\Request;

/**
 * Interface RuleInterface
 * @package App\interfaces
 */
interface RuleInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function valid(Request $request): bool;


    /**
     * @return string
     */
    public function message(): string;
}