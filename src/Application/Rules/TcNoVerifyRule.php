<?php


namespace App\Application\Rules;


use App\Components\Http\Request;
use App\interfaces\RuleInterface;

/**
 * Class TcNoVerifyRule
 * @package App\app\Rules
 */
class TcNoVerifyRule implements RuleInterface
{

    /**
     * @param Request $request
     * @return bool
     */
    public function valid(Request $request): bool
    {
        return ($request->post('tc_no') === 11111111);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'tc no verified';
    }
}