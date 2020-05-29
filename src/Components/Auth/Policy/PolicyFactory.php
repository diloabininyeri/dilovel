<?php


namespace App\Components\Auth\Policy;

use App\Application\Models\Users;
use App\Components\Database\Model;
use App\Interfaces\PolicyInterface;

/**
 * Class PolicyFactory
 * @package App\Components\Auth\Policy
 *
 */
class PolicyFactory
{


    /**
     * @var PolicyInterface
     */
    private PolicyInterface $policy;
    /**
     * @var Model
     */
    private Model $user;

    /**
     * PolicyFactory constructor.
     * @param Model $user
     * @param PolicyInterface $policy
     */
    public function __construct(Model $user, PolicyInterface $policy)
    {
        $this->policy = $policy;
        $this->user = $user;
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->policy, $name)) {
            array_unshift($arguments, $this->user);
            return $this->policy->$name(...$arguments);
        }
        return false;
    }
}
