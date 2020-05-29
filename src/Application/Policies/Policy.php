<?php


namespace App\Application\Policies;

use App\Components\Auth\Policy\AbstractPolicy;

/**
 * Class Policy
 * @package App\Application\Policies
 */
class Policy extends AbstractPolicy
{

    /**
     * @var array|string[]
     */
    protected array $policies=[

        'book'=>BookPolicy::class
    ];
}
