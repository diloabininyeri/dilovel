<?php


namespace App\Components\Routers;

use App\Components\Http\Request;
use Closure;
use function Composer\Autoload\includeFile;

/**
 * Class RouterAuth
 * @package App\Components\Routers
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
        return call_user_func([new $this->class(), $this->method], new Request());
    }

    /**
     *
     */
    public function __destruct()
    {
        if (($this->path === null) && $this->isAuthorization()) {
            call_user_func($this->closure);
        }
        if ($this->path && $this->isAuthorization()) {
            $path = str_replace('.', '/', $this->path);
            includeFile("src/Routers/$path.php");
        }
    }
}
