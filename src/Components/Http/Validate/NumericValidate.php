<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Interfaces\ValidatorInterface;

/**
 * Class NumericValidate
 * @package App\Components\Http\Validate
 */
class NumericValidate implements ValidatorInterface
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
        return is_numeric($request->get($input));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->input.' must be numeric';
    }
}
