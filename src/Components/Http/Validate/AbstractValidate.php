<?php


namespace App\Components\Http\Validate;

/**
 * Class AbstractValidate
 * @package App\Components\Http\Validate
 */
class AbstractValidate
{

    /**
     * @var string
     */
    protected string  $input;

    /**
     * @var string
     */
    protected ?string $optionalInputName=null;

    /**
     * AbstractValidate constructor.
     * @param string $input
     * @param string|null $optionalInputName
     */
    public function __construct(string $input, ?string $optionalInputName=null)
    {
        $this->input = $input;
        $this->optionalInputName = $optionalInputName;
    }
}
