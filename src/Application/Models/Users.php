<?php


namespace App\Application\Models;

use App\Application\Models\Objectable\UserName;
use App\Application\Models\Objectable\UserPassword;
use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\BuilderUserModel;
use App\Components\Database\Paginate;
use App\Components\Database\Relation\BelongsToMany;
use App\Components\Database\Relation\HasOne;

/**
 * Class Users
 * @package App\Models
 * @mixin BuilderQuery
 * @method   static Collection get(...$columns)
 * @property $name
 * @method static BuilderQuery|Users order()
 * @method static Paginate paginate(int $perPage)
 * @method static BuilderQuery|Users find(int $id)
 * @method static BuilderQuery|Users increment(string $column,int $inc)
 * @method static BuilderQuery|Users findOrFail(int $id)
 * @method static BuilderQuery|Users findByName(string $name)
 * @method static BuilderQuery|Users findById(int $id)
 */
class Users extends BuilderUserModel
{
    /**
     * @var string $table
     */
    protected string $table = 'users';

    /**
     * @var string
     */
    protected string  $connection = 'default';

    /**
     * @var array|string[]
     */
    protected array $hidden = ['password'];

    /**
     * @var array|string[]
     */
    protected array $filterable = ['id','name'];
    /**
     * @var array|string[]
     */
    protected array $objectable = [
        'name' => UserName::class,
        'password'=>UserPassword::class,
    ];

    /**
     * when this model is created this method trigger
     * for multi serve or multi host, set different connection name
     */
    public function onConstruct():void
    {
    }

    /**
     * @param BuilderQuery $query
     * @return BuilderQuery
     */
    public function scopeOrder(BuilderQuery $query)
    {
        return $query->orderByAsc();
    }

    /**
     * @return HasOne
     */
    public function book():HasOne
    {
        return $this->hasOne(Book::class, 'user_id', 'id')->withDefault(['email'=>777]);
    }

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }


    public function phone()
    {
        return $this->hasOne(Phone::class, 'user_id');
    }
    /**
     * @return HasOne
     */
    public function product():HasOne
    {
        return $this->hasOne(Products::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'user_id');
    }


    public function nameAndSurname()
    {
        return sprintf('%s %s', $this->name, $this->surname);
    }
}
