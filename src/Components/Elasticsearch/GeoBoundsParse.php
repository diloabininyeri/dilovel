<?php


namespace App\Components\Elasticsearch;

use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use JsonException;

/**
 * Class GeoBoundsParse
 * @package App\Components\Elasticsearch
 */
class GeoBoundsParse implements ArrayAble, ToJson
{

    /**
     * @var array
     */
    private array $geoBounds;

    /**
     * GeoBoundsParse constructor.
     * @param array $geoBounds
     */
    public function __construct(array $geoBounds)
    {
        $this->geoBounds = $geoBounds;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->geoBounds;
    }

    /**
     * @return string|null
     * @throws JsonException
     */
    public function toJson(): ?string
    {
        return json_encode($this->geoBounds, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function getHits(): array
    {
        return $this->geoBounds['hits']['hits'] ?? [];
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->geoBounds['aggregations']['geo_bounds']['bounds'] ?? [];
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function __toString()
    {
        return (string)$this->toJson();
    }
}
