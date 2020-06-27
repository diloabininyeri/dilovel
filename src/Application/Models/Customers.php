<?php

namespace App\Application\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;

/**
 * Class Customers
 * @package App\Models
 * @mixin BuilderQuery
 */
class Customers extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'customers';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = [];
}
