<?php


namespace App\Components\Elasticsearch;

use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use JsonException;

/**
 * Class TermAggregationParse
 * @package App\Components\Elasticsearch
 */
class TermAggregationParse implements ArrayAble, ToJson
{
    /**
     * @var array
     */
    private array $termsArray;

    /**
     * TermAggregationParse constructor.
     * @param array $termsArray
     */
    public function __construct(array $termsArray)
    {
        $this->termsArray = $termsArray;
    }

    /**
     * @return array
     */
    public function getHits(): array
    {
        return $this->termsArray['hits']['hits'];
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->termsArray['hits']['total']['value'] ?? 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->termsArray;
    }

    /**
     * @return array|mixed
     */
    public function getBuckets(): array
    {
        return $this->termsArray['aggregations']['terms_aggregation']['buckets'] ?? [];
    }


    /**
     * @return string
     * @throws JsonException
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toJson(): string
    {
        return (string)json_encode($this->termsArray, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
