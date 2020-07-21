<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidatorInterface;

/**
 * Class EmailValidate
 * @package App\Components\Http\Validate
 */
class EmailValidate extends AbstractValidate implements ValidatorInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        return filter_var($request->input($input), FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.email'));
    }
}
