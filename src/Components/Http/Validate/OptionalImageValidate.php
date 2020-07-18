<?php


namespace App\Components\Http\Validate;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Interfaces\ValidatorInterface;

/**
 * Class OptionalImageValidate
 * @package App\Components\Http\Validate
 */
class OptionalImageValidate implements ValidatorInterface
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
        if (!$request->hasFile($input)) {
            return  true;
        }
        return (new File($_FILES[$input]))->isImage();
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return  "$this->input must be image";
    }
}
