<?php

namespace App\Components;

use JsonException;

/**
 * Class Response
 * @package App\Components
 */
class ResponseCollection
{


    /**
     * @var array $collection
     */
    protected array $collection;

    /**
     * ResponseCollection constructor.
     * @param Collections $collection
     */
    public function __construct(Collections $collection)
    {

        $this->collection = $collection->getCollection();
    }

    /**
     * @return false|string
     * @throws JsonException
     */
    public function toJson()
    {
        $this->setHeader();
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR, 512);
    }

    /**
     *
     */
    private function setHeader(): void
    {
        header('Content-type:application/json');
    }


}