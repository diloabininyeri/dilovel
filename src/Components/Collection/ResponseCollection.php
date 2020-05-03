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
            return json_encode($this->toArray(), JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT, 512);
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

    /**
     * @return false|string
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
