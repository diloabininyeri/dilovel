<?php


namespace App\Components\Http;

use App\Interfaces\RuleInterface;

class ValidateRequests
{
    /**
     * @var array
     */
    private array $messages = [];

    /**
     * @var array
     */
    private array $rules;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * ValidateRequests constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function rules(array $rules):self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return $this
     */
    public function validate():self
    {
        array_map([$this, 'callRuleValidationMethod'], $this->rules);
        return $this;
    }

    /**
     * @param RuleInterface $rule
     * @return bool
     */
    private function callRuleValidationMethod(RuleInterface $rule): bool
    {
        if (!$rule->valid($this->request)) {
            $this->messages[] = $rule->message();
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isFailed():bool
    {
        return !empty($this->messages);
    }


    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
