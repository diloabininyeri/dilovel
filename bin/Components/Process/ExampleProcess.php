<?php


namespace Bin\Components\Process;

use App\Interfaces\ProcessForkInterface;
use Closure;
use Generator;

/**
 * Class ExampleProcess
 * @package Bin\Components\Process
 */
class ExampleProcess implements ProcessForkInterface
{

    /**
     * @return Closure
     */
    public function closure(): Closure
    {
        return static function ($value) {
            sleep(1);
            return $value."\n";
        };
    }

    /**
     * @param $error
     * @return mixed|void
     */
    public function failed($error)
    {
        print  $error;
    }


    /**
     * @return Generator
     */
    public function generateData(): Generator
    {
        foreach (range(1, 20000) as $item) {
            yield $item;
        }
    }
}
