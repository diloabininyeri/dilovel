<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidateLengthInterface;

/**
 * Class MinValidate
 * @package App\Components\Http\Validate
 */
class MinValidate implements ValidateLengthInterface
{
    /**
     * @var string|null
     */
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
        return (strlen($request->post($input))>$length);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->input, Lang::get('form.min'));
    }
}
