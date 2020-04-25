<?php


namespace App\Components;


use JsonException;

/**
 * Class Response
 * @package App\Components
 */
class Response
{

    /**
     * @var array
     */
    private array $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @return false|string
     * @throws JsonException
     */
    public function toJson()
    {
        $this->setHeader();
        return json_encode($this->array, JSON_THROW_ON_ERROR, 512);
    }

    /**
     *
     */
    private function setHeader(): void
    {
        header('Content-type:application/json');
    }


}