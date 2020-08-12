<?php


namespace App\Components\Elasticsearch;

use App\Interfaces\ArrayAble;
use JsonException;

/**
 * Class TermAggregationParse
 * @package App\Components\Elasticsearch
 */
class TermAggregationParse implements ArrayAble
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
    public function getHits():array
    {
        return $this->termsArray['hits']['hits'];
    }

    /**
     * @return int
     */
    public function getTotal():int
    {
        return  $this->termsArray['hits']['total']['value'] ?? 0;
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        return  $this->termsArray;
    }

    /**
     * @return array|mixed
     */
    public function getBuckets()
    {
        return $this->termsArray['aggregations']['terms_aggregation']['buckets'] ?? [];
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function __toString()
    {
        return (string)json_encode($this->termsArray, JSON_THROW_ON_ERROR|JSON_PRETTY_PRINT);
    }
}
