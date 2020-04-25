<?php


namespace App\interfaces;


/**
 * Interface FormRequestInterface
 * @package App\interfaces
 */
interface FormRequestInterface
{

    /**
     * @return array|RuleInterface[]
     */
    public function rules():array;
}