<?php


namespace App\Components\Http\Validate;

use App\Components\Http\Request;
use App\Interfaces\ValidatorInterface;

/**
 * Class RequiredValidate
 * @package App\Components\Http\Validate
 */
class RequiredValidate implements ValidatorInterface
{
    private ?string $input=null;
    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string  $input):bool
    {
        $this->input=$input;

        return $request->has($input);
    }

    /**
     * @return string
     */
    public function message():string
    {
        return "$this->input required";
    }
}
