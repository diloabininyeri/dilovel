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
class ImageValidate implements ValidatorInterface
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
        return (new File($_FILES[$input]))->isImage();
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return str_replace(':element', $this->input, Lang::get('form.image'));
    }
}
