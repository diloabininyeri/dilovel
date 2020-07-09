<?php


namespace App\Application\Models;

use App\Application\Models\Objectable\UserName;
use App\Application\Models\Objectable\UserPassword;
use App\Components\Collection\Collection;
use App\Components\Database\BuilderQuery;
use App\Components\Database\BuilderUserModel;
use App\Components\Database\HasOne;
use App\Components\Database\HasOneBuilder;
use App\Components\Database\Model;
use App\Components\Database\Paginate;

/**
 * Class Users
 * @package App\Models
 * @mixin BuilderQuery
 * @method   static Collection get(...$columns)
 * @property $name
 * @method static BuilderQuery|Users order()
 * @method static Paginate paginate(int $perPage)
 * @method static BuilderQuery|Users find(int $id)
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
     * @param BuilderQuery $query
     * @return BuilderQuery
     */
    public function scopeOrder(BuilderQuery $query)
    {
        return $query->orderByAsc();
    }

    /**
     * @return HasOneBuilder
     */
    public function book()
    {
        return $this->hasOne(Book::class, 'user_id', 'id');
    }


    public function nameAndSurname()
    {
        return sprintf('%s %s', $this->name, $this->surname);
    }
}
