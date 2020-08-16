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
    private array $query;
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
     * @param string $topLeft
     * @param string $bottomRight
     * @return $this
     */
    public function geoHash(string $topLeft, string $bottomRight): self
    {
        $this->query['filter']['geo_bounding_box'][$this->key]['top_left'] = $topLeft;
        $this->query['filter']['geo_bounding_box'][$this->key]['bottom_right'] = $bottomRight;
        return $this;
    }

    /**
     * @param mixed ...$coordinates
     * @return $this
     */
    public function wktBbox(...$coordinates): self
    {
        $points = implode(',', $coordinates);
        $this->query['filter']['geo_bounding_box'][$this->key]['wkt'] = "BBOX ($points)";
        return $this;
    }

    /**
     * @param $top
     * @param $left
     * @return $this
     */
    public function topLeft($top, $left): self
    {
        $this->query['filter']['geo_bounding_box'][$this->key]['top_left'] = ['lat' => $top, 'lon' => $left];
        return $this;
    }

    /**
     * @param $bottom
     * @param $right
     * @return $this
     */
    public function bottomRight($bottom, $right): self
    {
        $this->query['filter']['geo_bounding_box'][$this->key]['bottom_right'] = ['lat' => $bottom, 'lon' => $right];

        return $this;
    }
}
