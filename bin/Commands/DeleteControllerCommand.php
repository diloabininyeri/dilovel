<?php /**@noinspection PhpUnused*/


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

/**
 * Class DeleteControllerCommand
 * @package Bin\Commands
 */
class DeleteControllerCommand implements CommandInterface
{
    /**
     * @var string $namespace
     */
    private string $namespace = 'src/Application/Controllers';


    /**
     * @var string $description
     * @noinspection PhpUnused
     */
    protected string $description = 'delete  controller is very simple';

    /**
     * @param array|null $parameters
     * @noinspection PhpUnused
     */
    public function handle(?array $parameters): void
    {
        $controller = $parameters[0];
        $path = $this->createPath($controller);
        if (file_exists($path)) {
            unlink($path);
            echo $this->deletedMessage($controller);
        } else {
            echo $this->notFoundMessage($controller);
        }
    }

    /**
     * @param $controller
     * @return string
     */
    private function createPath($controller): string
    {
        return sprintf('%s/%s.php', $this->namespace, $controller);
    }

    /**
     * @param $controller
     * @return string
     */
    private function notFoundMessage($controller): string
    {
        return ColorConsole::getInstance()->getColoredString("not found $controller controller \n", 'red');
    }

    /**
     * @param $controller
     * @return string
     *
     */
    private function deletedMessage($controller): string
    {
        return  ColorConsole::getInstance()->getColoredString("$controller controller deleted\n", 'green');
    }
}
