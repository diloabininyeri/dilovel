<?php

namespace App\Components\Collection;

use App\Components\Exceptions\JsonEncodeException;
use JsonException;

/**
 * Class Response
 * @package App\Components
 */
abstract class ResponseCollection
{


    /**
     * @var array $collection
     */
    protected array $collection;

    /**
     * ResponseCollection constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection->getCollection();
    }


    /**
     * @return false|string
     */
    public function toJson()
    {
        $this->setHeader();
        try {
            return json_encode($this->toArray(), JSON_THROW_ON_ERROR, 512);
        } catch (JsonException $e) {

            throw  new JsonEncodeException($e->getMessage());
        }
    }

    /**
     *
     */
    private function setHeader(): void
    {
        header('Content-type:application/json');
    }


}