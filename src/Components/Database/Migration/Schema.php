<?php


namespace App\Components\Database\Migration;

use App\Components\Database\PDOAdaptor;
use Bin\Components\ColorConsole;
use Closure;
use Exception;

/**
 * Class Schema
 * @package App\Components\Database\Migration
 */
class Schema
{
    /**
     * @var string
     */
    private string  $pdoConnectionName;

    /**
     * Schema constructor.
     * @param string $pdoConnectionName
     */
    public function __construct(string $pdoConnectionName)
    {
        $this->pdoConnectionName=$pdoConnectionName;
    }

    /**
     * @param string $name
     * @return Schema
     */
    public static function connection($name='default'): Schema
    {
        return new self($name);
    }

    /**
     * @param string $table
     * @param Closure $closure
     * @return mixed
     */
    public function create(string $table, Closure  $closure)
    {
        return  $closure(new MigrationBuilder($table, $this->pdoConnectionName));
    }
    /**
     * @param string $table
     * @throws Exception
     */
    public function drop(string $table): void
    {
        $isDeleted=PDOAdaptor::connection($this->pdoConnectionName)->exec("DROP TABLE IF EXISTS $table");
        if ($isDeleted) {
            echo ColorConsole::getInstance()->getColoredString("$table deleted").PHP_EOL;
        }
    }
}
