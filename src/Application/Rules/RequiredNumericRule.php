<?php


namespace App\Application\Rules;

use App\Components\Http\Request;
use App\Interfaces\RuleInterface;

class RequiredNumericRule implements RuleInterface
{
    public function valid(Request $request): bool
    {
        return is_numeric($request->post('tc_no'));
    }

    public function message(): string
    {
        return  'tc no must be numeric';
    }
}
