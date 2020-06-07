<?php


namespace App\Components\Database\Migration;

use App\Components\Database\PDOAdaptor;
use Closure;
use Exception;

class Schema
{
    private string  $pdoConnectionName;

    public function __construct(string $pdoConnectionName)
    {
        $this->pdoConnectionName=$pdoConnectionName;
    }

    public static function connection($name='default'): Schema
    {
        return new self($name);
    }

    public function create(string $table, Closure  $closure)
    {
        return  $closure(new MigrationBuilder($table, $this->pdoConnectionName));
    }


    /**
     * @param string $table
     * @throws Exception
     */
    public function drop(string $table)
    {
        PDOAdaptor::connection($this->pdoConnectionName)->exec("DROP TABLE $table");
    }
}
