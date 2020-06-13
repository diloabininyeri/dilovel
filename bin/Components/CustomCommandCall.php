<?php


namespace Bin\Components;

use RuntimeException;

/**
 * Class CustomCommandCall
 * @package Bin\Components
 */
abstract class CustomCommandCall
{

    /**
     * @var array $signals
     */
    private array $signals;


    /**
     * CustomCommandCall constructor.
     */
    public function __construct()
    {
        if (!empty(func_get_args())) {
            $this->parseParameters(func_get_args());
        }
    }

    /**
     * @param $parameter
     */
    private function parseParameters($parameter): void
    {
        [$params, $count] = $parameter;

        if ($count < 2) {
            die(shell_exec('php console list'));
        }
        $this->signals = array_slice($params, 1);
    }

    /**
     * @return mixed
     *
     */
    final public function run(): void
    {
        $commandClass = $this->getCommands($this->signals[0]);

        if (class_exists($commandClass)) {
            (new $commandClass())->handle(array_slice($this->signals, 1));
        } else {
            echo $this->createNotFoundMessage($this->findSimilarCommand($this->signals[0]));
        }
    }


    /**
     * @param $command
     * @return mixed
     */
    private function findSimilarCommand($command)
    {
        $similarCommands = $this->sortSimilarity($command);
        return $similarCommands[0]['command'];
    }

    /**
     * @param $command
     * @return array[]
     */
    private function sortSimilarity($command): array
    {
        $similarRate = array_map(static function ($cmd) use ($command) {
            return
                [
                    'similarity' => similar_text($cmd, $command),
                    'command' => $cmd
                ];
        }, array_keys($this->getCommands()));

        uasort($similarRate, fn ($cmd, $cmd1) => -($cmd['similarity'] <=> $cmd1['similarity']));
        return array_values($similarRate);
    }

    /**
     * @param null $key
     * @return mixed
     */
    private function getCommands($key = null)
    {
        if ($key === null) {
            return $this->commands;
        }
        return $this->commands[$key] ?? null;
    }


    /**
     * @param $command
     * @return string
     */
    private function createNotFoundMessage($command): string
    {
        echo "did you mean  \n=>php console $command   yes/no : ";
        $confirm=$this->readLine('');
        if ($confirm === 'yes') {
            return  shell_exec("php console $command");
        }
        return ColorConsole::getInstance()->getColoredString("\naborted\n", 'red');
    }

    /**
     * @param string $quiz
     * @return string
     */
    private function readLine(string $quiz): string
    {
        $fh = fopen('php://stdin', 'rb');
        $userInput = trim(fgets($fh));
        fclose($fh);

        return $userInput;
    }
}
