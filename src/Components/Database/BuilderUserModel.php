<?php


namespace App\Components\Database;


use App\Application\Policies\Policy;
use App\Components\Auth\Policy\PolicyFactory;
use App\Components\Exceptions\PolicyNotFoundException;
use App\Interfaces\Autocomplete\PolicyAutocomplete;

class BuilderUserModel extends Model
{

    /**
     * @param string $policy
     * @return PolicyFactory|PolicyAutocomplete
     * @throws PolicyNotFoundException
     */
    final public function can(string $policy)
    {
        $class = new Policy();
        return new PolicyFactory($this, $class->createPolicyObject($policy));
    }
}
