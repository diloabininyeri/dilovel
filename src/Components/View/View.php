<?php


namespace App\Components\View;

use App\Components\Blade\Blade;
use App\Components\Enums\FormValidationEnum;
use App\Components\Exceptions\ViewNotFoundException;
use RuntimeException;

/**
 * Class View
 * @package App\Components\View
 */
class View
{

    /**
     * @var string
     */
    private string $blade;

    /**
     * @var array|null
     */
    private ?array $variables;


    /**
     * View constructor.
     * @param string $view
     * @param array|null $variables
     */
    public function __construct(string $view, ?array $variables = [])
    {
        $view=$this->dotNotationTPath($view);
        $this->blade = "src/Views/$view.blade.php";
        $this->variables = $variables;
        if (!file_exists($this->blade)) {
            throw new ViewNotFoundException("$view view Not Found");
        }
    }

    /**
     * @param string $notation
     * @return string
     */
    private function dotNotationTPath(string $notation): string
    {
        return implode('/', explode('.', $notation));
    }

    /**
     * @return mixed
     */
    private function renderWithBlade()
    {
        $bladeClass = new Blade();
        $bladeClass->render(file_get_contents($this->blade));
        return $bladeClass->renderWithCustomDirective();
    }


    /**
     * @return false|string
     */
    private function getHashBlade()
    {
        return md5_file($this->blade);
    }

    /**
     * @return false|string
     */
    public function compile()
    {
        if ($this->isBladeCacheExists()) {
            return $this->builderReturnBlade();
        }
        $this->filePutViewCache();
        return $this->builderReturnBlade();
    }

    /**
     * @return object
     */
    private function createFormErrors()
    {
        return(object)(error()->getFormErrors() ?? error()->all());
    }
    /**
     * @return string
     * @noinspection PhpIncludeInspection
     */
    private function builderReturnBlade():string
    {
        $this->variables['errors']=$this->createFormErrors();
        extract($this->variables, EXTR_OVERWRITE);
        ob_start();
        require $this->getBladeCachePath();
        return ob_get_clean();
    }

    /**
     * @return string
     */
    private function getBladeCachePath(): string
    {
        return 'src/Views/caches/' .$this->getHashBlade(). '.php';
    }

    /**
     * @return bool
     */
    private function isBladeCacheExists():bool
    {
        return file_exists($this->getBladeCachePath());
    }

    private function filePutViewCache(): void
    {
        $this->checkCacheDir();
        $md5=$this->getHashBlade();
        file_put_contents("src/Views/caches/$md5.php", $this->renderWithBlade());
    }

    public function checkCacheDir() : void
    {
        if (!is_dir("src/Views/caches/") && !mkdir("src/Views/caches/", 0777, true) && !is_dir("src/Views/caches/")) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', "src/Views/caches/"));
        }
    }
}
