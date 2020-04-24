<?php


namespace App\app\Models;

use App\app\Models\Objectable\UserName;
use App\app\Models\Objectable\UserPassword;
use App\Database\BuilderQuery;
use App\Database\Model;
use App\Models\HasOne;


/**
 * Class Users
 * @package App\Models
 * @mixin BuilderQuery
 * @method  static get()
 * @property $name
 * @method static BuilderQuery|Users order()
 * @method static BuilderQuery|Users find(int $id)
 * @method static BuilderQuery|Users findOrFail(int $id)
 */
class Users extends Model
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
    protected array $hidden = [];

    /**
     * @var array|string[]
     */
    protected array $objectable = [
        'name' => UserName::class,
        'password'=>UserPassword::class,
    ];



    public function setPasswordAttribute($value)
    {
       return md5($value);
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
     * @return Book|HasOne
     */
    public function book()
    {
        return $this->hasOne(Book::class, 'user_id', 'id');
    }


    public function car()
    {
        return random_int(1, 123);
    }

}