<?php


namespace App\Components\Elasticsearch;

/**
 * Class GeoBoundingBox
 * @package App\Components\Elasticsearch
 */
class GeoBoundingBox
{


    /**
     * @var array
     */
    public array $query = [];
    /**
     * @var string
     */
    private string $key;

    /**
     * GeoBoundingBox constructor.
     * @param array $query
     * @param string $key
     */
    public function __construct(array &$query, string $key)
    {
        $this->query = &$query;
        $this->key = $key;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return $this
     */
    public function topLeft($latitude, $longitude): self
    {
        $this->query['filter']['geo_bounding_box'][$this->key]['top_left'] =['lat' => $latitude, 'lon' => $longitude];
        return  $this;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @return $this
     */
    public function bottomRight($latitude, $longitude): self
    {
        $this->query['filter']['geo_bounding_box'][$this->key]['bottom_right'] =['lat' => $latitude, 'lon' => $longitude];

        return $this;
    }
}
