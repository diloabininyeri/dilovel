<?php


namespace App\Components\Pipeline;

/**
 * Class Pipeline
 * @package App\Components\Pipeline
 */
class Pipeline
{
    /**
     * @var
     */
    private $data;

    /**
     * Pipeline constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param callable $callable
     * @return $this
     */
    public function pipe(callable $callable): self
    {
        $this->data = ($callable($this->data));
        return $this;
    }

    /**
     * @return mixed
     */
    public function process()
    {
        return $this->data;
    }
}
