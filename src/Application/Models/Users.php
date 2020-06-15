<?php


namespace App\Application\Models;

use App\Application\Models\Objectable\UserName;
use App\Application\Models\Objectable\UserPassword;
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
 * @method  static get(...$columns)
 * @property $name
 * @method static BuilderQuery|Users order()
 * @method static Paginate paginate(int $perPage)
 * @method static BuilderQuery|Users find(int $id)
 * @method static BuilderQuery|Users findOrFail(int $id)
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
    protected array $hidden = [];

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
