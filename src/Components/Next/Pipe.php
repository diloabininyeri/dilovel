<?php


namespace App\Components\Next;

use App\Interfaces\PipeAble as PipeAbleInterface;

class Pipe
{


    /**
     * @var
     */
    private $data;

    /**
     * @var array
     */
    private array $objects;

    /**
     * Pipe constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param PipeAbleInterface $conditionObject
     * @return $this
     */
    public function addObject(PipeAbleInterface $conditionObject): self
    {
        $this->objects[] = $conditionObject;
        return $this;
    }

    /**
     * @return array
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * @return bool
     */
    public function passed():bool
    {
        return empty($this->getCantNextPipeResponses());
    }

    /**
     * @return array
     */
    public function getPipeResponses():array
    {
        $responses=[];
        $pipe=new PipeAble();
        /**
         * @var $object PipeAbleInterface
         */
        foreach ($this->objects as $object) {
            $responses[]=$object->condition($this->data, $pipe);
        }
        return $responses;
    }

    /**
     * @return array
     */
    public function getCantNextPipeResponses(): array
    {
        $result=[];
        $next=new PipeAble();
        /**
         * @var PipeAbleInterface $object
         */
        foreach ($this->objects as $object) {
            if (!($response=$object->condition($this->data, $next)) instanceof PipeAbleInterface) {
                $result[]=$response;
            }
        }
        return $result;
    }
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
