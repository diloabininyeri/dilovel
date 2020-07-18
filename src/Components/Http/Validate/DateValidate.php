<?php


namespace App\Components\Http\Validate;


use App\Components\Http\Request;
use App\Interfaces\ValidatorInterface;

/**
 * Class DateValidate
 * @package App\Components\Http\Validate
 */
class DateValidate implements ValidatorInterface
{

    /**
     * @var string|null
     */
    private ?string $input=null;

    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        $this->input=$input;
        return (bool) strtotime($request->get($input));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return  "$this->input must be date";
    }
}