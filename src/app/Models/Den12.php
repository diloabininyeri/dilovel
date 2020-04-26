<?php

namespace App\app\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;


/**
 * Class Den12
 * @package App\Models
 * @mixin BuilderQuery
 */
class Den12 extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'den';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = [];



}