<?php


namespace App\Components\Route;

use App\Components\Http\Request;
use Closure;
use function Composer\Autoload\includeFile;

/**
 * Class RouterAuth
 * @package App\Components\Route
 */
class RouterAuth
{

    /**
     * @var string
     */
    private string $class;
    /**
     * @var string
     */
    private string $method;
    /**
     * @var Closure
     */
    private ?Closure $closure;
    /**
     * @var string|null
     */
    private ?string $path=null;

    /**
     * RouterAuth constructor.
     * @param string $class
     * @param string $method
     * @param Closure $closure
     */
    public function __construct(string $class, string $method, Closure $closure=null)
    {
        $this->class = $class;
        $this->method = $method;
        $this->closure = $closure;
    }

    /**
     * @param string $path
     */
    public function path(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return bool
     */
    private function isAuthorization(): bool
    {
        return call_user_func([new $this->class(), $this->method], Request::getInstance());
    }

    private function loadRouterFile():void
    {
        if ($this->path) {
            $path = str_replace('.', '/', $this->path);
            includeFile("src/Route/$path.php");
        }
    }

    /**
     * @return bool
     */
    private function loadCondition():bool
    {
        return PHP_SAPI==='cli' || ($this->path && $this->isAuthorization());
    }
    /**
     *
     */
    public function __destruct()
    {
        if (($this->path === null) && $this->isAuthorization()) {
            call_user_func($this->closure);
        }
        if ($this->loadCondition()) {
            $this->loadRouterFile();
        }
    }
}
