<?php


namespace App\Application\Rules;

use App\Components\Http\Request;
use App\Interfaces\RuleInterface;

class RequiredRule implements RuleInterface
{
    public function valid(Request $request): bool
    {
        return  !empty($request->post('tc_no'));
    }

    public function message(): string
    {
        return "pelase write some things";
    }
}
