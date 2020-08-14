<?php


namespace App\Components\Elasticsearch;

use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use JsonException;

/**
 * Class GeoCentroidParse
 * @package App\Components\Elasticsearch
 */
class GeoCentroidParse implements ArrayAble, ToJson
{

    /**
     * @var array
     */
    private array $centroid;

    /**
     * GeoCentroidParse constructor.
     * @param array $centroid
     */
    public function __construct(array $centroid)
    {
        $this->centroid = $centroid;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->centroid;
    }

    /**
     * @return string|null
     * @throws JsonException
     */
    public function toJson(): ?string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function getHits(): array
    {
        return $this->centroid['hits']['hits'] ?? [];
    }

    /**
     * @return array
     */
    public function getLocation(): array
    {
        return $this->centroid['aggregations']['geo_centroid']['location'] ?? [];
    }

    /**
     * @return int
     */
    public function getCount():int
    {
        return $this->centroid['aggregations']['geo_centroid']['count'] ?? 0;
    }

    /**
     * @return array
     */
    public function getDetail(): array
    {
        return $this->centroid;
    }
    /**
     * @return string
     * @throws JsonException
     */
    public function __toString(): string
    {
        return (string)$this->toJson();
    }
}
