<?php


namespace App\Components\Elasticsearch;

/**
 * Class GeoShape
 * @package App\Components\Elasticsearch
 */
class GeoShape
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
     * @var string
     */
    private string $type = 'envelope';
    /**
     * @var ?string
     */
    private ?string $relation = null;

    /**
     * GeoShape constructor.
     * @param array $query
     * @param string $key
     */
    public function __construct(array &$query, string $key)
    {
        $this->query = &$query;
        $this->key = $key;
    }

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        $this->query['filter'][]['geo_shape'] = [
            $this->key => [
                'shape' => [
                    'type' => $this->type,
                    'coordinates' => $coordinates
                ]
            ],
            'relation' => $this->relation

        ];
        return $this;
    }

    /**
     * @param string $type
     * @return GeoShape
     */
    public function setType(string $type): GeoShape
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $relation
     * @return GeoShape
     */
    public function setRelation(string $relation): GeoShape
    {
        $this->relation = $relation;
        return $this;
    }
}
