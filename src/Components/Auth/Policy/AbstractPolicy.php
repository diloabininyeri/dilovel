<?php


namespace App\Components\Auth\Policy;

/**
 * Class AbstractPolicy
 * @package App\Components\Auth\Policy
 */
abstract class AbstractPolicy
{


    /**
     * @param string $policy
     * @return mixed
     */
    public function createPolicyObject(string $policy)
    {
        $class= $this->getPolicies()[$policy] ?? null;
        if ($class !==null) {
            return new $class();
        }
    }

    /**
     * @return array
     */
    public function getPolicies():array
    {
        return  $this->policies;
    }
}
