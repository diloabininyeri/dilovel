<?php


namespace App\Components\View;

use App\Components\Blade\Blade;
use App\Components\Exceptions\ViewNotFoundException;

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
        return implode('/',explode('.',$notation));
    }

    /**
     * @return mixed
     */
    private function renderWithBlade()
    {
        $bladeClass = new Blade();
        return $bladeClass->render(file_get_contents($this->blade));
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
        $this->filePutViewCache();
        extract($this->variables, EXTR_OVERWRITE);
        ob_start();
        include 'src/Views/caches/' .$this->getHashBlade(). '.php';
        return ob_get_clean();
    }

    private function filePutViewCache(): void
    {
        $md5=$this->getHashBlade();
        file_put_contents("src/Views/caches/$md5.php", $this->renderWithBlade());
    }
}
