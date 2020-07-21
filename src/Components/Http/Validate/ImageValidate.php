<?php


namespace App\Components\Http\Validate;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidatorInterface;

/**
 * Class ImageValidate
 * @package App\Components\Http\Validate
 */
class ImageValidate extends AbstractValidate implements ValidatorInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        if ($request->hasFile($input)) {
            return (new File($_FILES[$input]))->isImage();
        }
        return  false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.image'));
    }
}
