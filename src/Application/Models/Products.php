<?php

namespace App\Application\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;

/**
 * Class Products
 * @package App\Models
 * @mixin BuilderQuery
 */
class Products extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'products';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = [];
}
