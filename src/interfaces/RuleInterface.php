<?php


namespace App\interfaces;


/**
 * Interface RuleInterface
 * @package App\interfaces
 */
interface RuleInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function valid($value): bool;


    /**
     * @return string
     */
    public function message(): string;
}