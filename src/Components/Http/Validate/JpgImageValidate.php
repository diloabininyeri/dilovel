<?php


namespace App\Components\Http\Validate;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Components\Lang\Lang;
use App\Interfaces\ValidatorInterface;

/**
 * Class JpgImageValidate
 * @package App\Components\Http\Validate
 */
class JpgImageValidate extends AbstractValidate implements ValidatorInterface
{

    /**
     * @param Request $request
     * @param string $input
     * @return bool
     */
    public function valid(Request $request, string $input): bool
    {
        $mimes=['image/jpg','image/jpeg'];
        if ($request->hasFile($input)) {
            $file = new File($_FILES[$input]);
            return (in_array($file->getMimeType(), $mimes, true));
        }
        return false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->optionalInputName ?: $this->input, Lang::get('form.jpg_image'));
    }
}
