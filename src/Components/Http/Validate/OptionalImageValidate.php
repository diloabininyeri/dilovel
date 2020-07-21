<?php


namespace App\Components\Http\Validate;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidatorInterface;

/**
 * Class OptionalImageValidate
 * @package App\Components\Http\Validate
 */
class OptionalImageValidate extends AbstractValidate implements ValidatorInterface
{
    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
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
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.optional_image'));
    }
}
