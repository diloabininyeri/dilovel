<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidateLengthInterface;

/**
 * Class MinValidate
 * @package App\Components\Http\Validate
 */
class MinValidate extends AbstractValidate implements ValidateLengthInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @param int $length
     * @return bool
     */
    public function valid(Request $request, string $input, int $length): bool
    {
        return (strlen($request->post($input))>$length);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.min'));
    }
}
