<?php


namespace Bin\Components\Process;

use App\Interfaces\ProcessForkInterface;
use Exception;

/**
 * Class Process
 * @package Bin\Components\Process
 */
class Process
{


    /**
     * @var ProcessForkInterface
     */
    private ProcessForkInterface $processFork;

    public function __construct(ProcessForkInterface $processFork)
    {
        $this->processFork = $processFork;
    }


    /**
     *
     */
    public function runOneByOneClosure(): void
    {
        foreach ($this->processFork->generateData() as $data) {
            try {
                $processId = pcntl_fork();
                if (!$processId) {
                    print call_user_func($this->processFork->closure(), $data);
                    exit();
                }
            } catch (Exception $exception) {
                $this->processFork->failed($exception->getMessage());
            }
        }

        $this->wait();
    }

    /**
     *
     */
    private function wait(): void
    {
        while (pcntl_waitpid(0, $status) !== -1) {
            $status = pcntl_wexitstatus($status);
        }
    }
}
