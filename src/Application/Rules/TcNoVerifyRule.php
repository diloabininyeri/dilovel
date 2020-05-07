<?php


namespace App\Application\Rules;

use App\Components\Http\Request;
use App\Interfaces\RuleInterface;

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
        return ($request->post('tc_no') == 11);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'tc not verified';
    }
}
