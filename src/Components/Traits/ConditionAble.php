<?php


namespace App\Components\Traits;

/**
 * Trait ConditionAble
 * @package App\Components\Traits
 */
trait ConditionAble
{
    /**
     * @param $condition
     * @param $callable
     * @return $this
     */
    public function when($condition, $callable): self
    {
        if ($condition) {
            $callable($this, $condition);
        }
        return $this;
    }

    public function whenReturnCallback(bool $condition, callable $callable)
    {
        if ($condition) {
            return  $callable($this, $condition);
        }
        return $this;
    }

    /**
     * @param $condition
     * @param $callable
     * @return ConditionAble
     */
    public function unless($condition, $callable): self
    {
        return $this->when(!$condition, $callable);
    }
}
