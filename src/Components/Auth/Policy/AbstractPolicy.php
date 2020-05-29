<?php


namespace App\Components\Auth\Policy;

use App\Components\Exceptions\PolicyNotFoundException;

/**
 * Class AbstractPolicy
 * @package App\Components\Auth\Policy
 */
abstract class AbstractPolicy
{


    /**
     * @param string $policy
     * @return mixed
     * @throws PolicyNotFoundException
     */
    public function createPolicyObject(string $policy)
    {
        $class= $this->getPolicies()[$policy] ?? null;
        if ($class !==null) {
            return new $class();
        }

        throw  new PolicyNotFoundException("$policy policy not found");
    }

    /**
     * @return array
     */
    public function getPolicies():array
    {
        return  $this->policies;
    }
}
