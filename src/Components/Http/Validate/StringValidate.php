<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidatorInterface;

/**
 * Class StringValidate
 * @package App\Components\Http\Validate
 */
class StringValidate extends AbstractValidate implements ValidatorInterface
{
    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        return is_string($request->post($input));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.string'));
    }
}
