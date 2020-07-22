<?php


namespace App\Components\Http;

use App\Components\Http\Validate\DateValidate;
use App\Components\Http\Validate\EmailValidate;
use App\Components\Http\Validate\ImageValidate;
use App\Components\Http\Validate\JpgImageValidate;
use App\Components\Http\Validate\MaxValidate;
use App\Components\Http\Validate\MinValidate;
use App\Components\Http\Validate\NumericValidate;
use App\Components\Http\Validate\OptionalImageValidate;
use App\Components\Http\Validate\RequiredValidate;
use App\Components\Http\Validate\StringValidate;
use App\Interfaces\ValidateLengthInterface;
use App\Interfaces\ValidatorInterface;

/**
 * Class AdvanceValidateRequest
 * @package App\Components\Http
 */
class AdvanceValidateRequest
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var array
     */
    private array $validators;

    /**
     * @var array
     */
    private array $messages = [];

    /**
     * @var array|string[]
     */
    private array $rules = [

        'string' => StringValidate::class,
        'required' => RequiredValidate::class,
        'numeric' => NumericValidate::class,
        'max' => MaxValidate::class,
        'min'=>MinValidate::class,
        'date'=>DateValidate::class,
        'image'=>ImageValidate::class,
        'email'=>EmailValidate::class,
        'optional_image'=>OptionalImageValidate::class,
        'jpg_image'=>JpgImageValidate::class,
    ];

    /**
     * AdvanceValidateRequest constructor.
     * @param array $validators
     * @param Request $request
     */
    public function __construct(array $validators, Request $request)
    {
        $array = [];
        foreach ($validators as $input => $condition) {
            $array[$input] = array_map('trim', explode('|', $condition));
        }

        $this->validators = $array;
        $this->request = $request;
    }

    /**
     * @param string $input
     * @return array|mixed
     */
    public function getError(string $input)
    {
        return $this->messages[$input] ?? [];
    }

    /**
     * @param bool $flatten
     * @return array
     */
    public function getErrors($flatten = true): array
    {
        if ($flatten) {
            $messages = $this->messages;
            return array_flatten($messages);
        }
        return $this->messages;
    }

    /**
     * @return $this
     */
    public function validate():self
    {
        foreach ($this->validators as $prefixInput => $validators) {
            foreach ($validators as $validator) {
                $explodePrefixInput= explode('|', $prefixInput);
                if (isset($explodePrefixInput[1])) {
                    [$input,$optionalInputName]=$explodePrefixInput;
                } else {
                    $input=$explodePrefixInput[0];
                    $optionalInputName=null;
                }
                $this->makeValidate($input, $validator, $optionalInputName);
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isFailed(): bool
    {
        return !empty($this->messages);
    }

    /**
     * @param string $inputName
     * @param string $validator
     * @param string $optionalInputName
     */
    private function makeValidate(string $inputName, string $validator, string $optionalInputName=null): void
    {
        /**
         * @var ValidatorInterface $validatorObject
         * @var ValidateLengthInterface $validatorLengthObject
         */
        if (strpos($validator, ':') === false) {
            $validatorObject = (new $this->rules[$validator]($inputName, $optionalInputName));
            if (!$validatorObject->valid($this->request, $inputName)) {
                $this->messages[$inputName][] = $validatorObject->message();
            }
        } else {
            [$validatorName, $length] = explode(':', $validator);
            $validatorLengthObject = (new $this->rules[$validatorName]($inputName, $optionalInputName));
            if (!$validatorLengthObject->valid($this->request, $inputName, $length)) {
                $this->messages[$inputName][] = $validatorLengthObject->message();
            }
        }
    }
}
