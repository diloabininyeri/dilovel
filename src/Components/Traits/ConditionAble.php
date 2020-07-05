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
    public function when($condition, $callable): ConditionAble
    {
        if ($condition) {
            $callable($this, $condition);
        }
        return $this;
    }

    /**
     * @param $condition
     * @param $callable
     * @return ConditionAble
     */
    public function unless($condition, $callable): ConditionAble
    {
        return $this->when(!$condition, $callable);
    }
}
