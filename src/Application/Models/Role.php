<?php

namespace App\Application\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;
use App\Components\Database\Relation\BelongsToMany;

/**
 * Class Role
 * @package App\Models
 * @mixin BuilderQuery
 */
class Role extends Model
{
    /**
     * @var string $table
     */
    protected string $table = 'roles';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = [];


    public function users()
    {
        return $this->belongsToMany(Users::class, 'user_roles', 'role_id', 'user_id');
    }
}
