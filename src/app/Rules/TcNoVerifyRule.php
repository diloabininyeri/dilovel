<?php


namespace App\app\Rules;


use App\interfaces\RuleInterface;

/**
 * Class TcNoVerifyRule
 * @package App\app\Rules
 */
class TcNoVerifyRule implements RuleInterface
{

    /**
     * @param $value
     * @return bool
     */
    public function valid($value): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'tc no verified';
    }
}