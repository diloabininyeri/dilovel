<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Interfaces\ValidatorInterface;

/**
 * Class StringValidate
 * @package App\Components\Http\Validate
 */
class StringValidate implements ValidatorInterface
{
    private ?string $input=null;
    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        $this->input=$input;
        return is_string($request->get($input));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return "$this->input field is must be string";
    }
}
