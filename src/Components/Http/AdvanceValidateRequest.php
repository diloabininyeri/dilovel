<?php


namespace App\Components\Http;

use App\Components\Http\Validate\MaxValidate;
use App\Components\Http\Validate\MinValidate;
use App\Components\Http\Validate\NumericValidate;
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
            $array[$input] = array_map('trim',explode('|', $condition));
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
        foreach ($this->validators as $inputName => $validators) {
            foreach ($validators as $validator) {
                $this->makeValidate($inputName, $validator);
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
     */
    private function makeValidate(string $inputName, string $validator): void
    {
        /**
         * @var ValidatorInterface $validatorObject
         * @var ValidateLengthInterface $validatorLengthObject
         */
        if (strpos($validator, ':') === false) {
            $validatorObject = (new $this->rules[$validator]);
            if (!$validatorObject->valid($this->request, $inputName)) {
                $this->messages[$inputName][] = $validatorObject->message();
            }
        } else {
            [$validatorName, $length] = explode(':', $validator);
            $validatorLengthObject = (new $this->rules[$validatorName]);
            if (!$validatorLengthObject->valid($this->request, $inputName, $length)) {
                $this->messages[$inputName][] = $validatorLengthObject->message();
            }
        }
    }
}
