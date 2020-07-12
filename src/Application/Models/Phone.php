<?php

namespace App\Application\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;

/**
 * Class Phone
 * @package App\Models
 * @mixin BuilderQuery
 * @method static BuilderQuery|Phone find(int $id)
 * @method static BuilderQuery|Phone first()
 */
class Phone extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'phones';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = [];


    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
