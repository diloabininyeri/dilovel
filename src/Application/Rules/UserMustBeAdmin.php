<?php


namespace App\Application\Rules;

use App\Components\Http\Request;
use App\Interfaces\RuleInterface;

class UserMustBeAdmin implements RuleInterface
{
    public function valid(Request $request): bool
    {
        return $request->get('user') === 'admin';
    }

    public function message(): string
    {
        return "user must be admin";
    }
}
