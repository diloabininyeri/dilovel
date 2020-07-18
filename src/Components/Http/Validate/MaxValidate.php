<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Interfaces\ValidateLengthInterface;
use App\Interfaces\ValidatorInterface;

/**
 * Class MaxValidate
 * @package App\Components\Http\Validate
 */
class MaxValidate implements ValidateLengthInterface
{
    private ?string $input=null;
    /**
     * @param Request $request
     * @param string $input
     * @param int $length
     * @return bool
     */
    public function valid(Request $request, string $input, int $length): bool
    {
        $this->input=$input;
        return (strlen($request->post($input))<$length);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return "$this->input to max";
    }
}
