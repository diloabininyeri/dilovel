<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;
use Elasticsearch\Client;
use stdClass;

/**
 * Class ElasticBoolQuery
 * @package App\Components\Elasticsearch
 */
class ElasticBoolQuery
{
    /**
     * @var array
     */
    private array $query = [];

    /**
     * @var int|null
     */
    private ?int $size = null;

    /**
     * @var int|null
     */
    private ?int $from = null;

    /**
     * @var array
     */
    private array $sort = [];

    /**
     * @var int|null
     */
    private ?int $minShouldMatch = null;


    /**
     * @var int|null
     */
    private ?int $boost = null;
    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * BoolQuery constructor.
     * @param ElasticBuilderQuery $builderQuery
     */
    public function __construct(ElasticBuilderQuery $builderQuery)
    {
        $this->client = Elastic::connection();
        $this->builderQuery = $builderQuery;
    }


    /**
     * @return $this
     */
    public function mustMatchAll(): self
    {
        $this->query['must'][] = ['match_all' => new stdClass()];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function mustMatch(string $key, $value): self
    {
        $this->query['must'][] = ['match' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param array $keys
     * @param $value
     * @param string $fuzziness
     * @param int $maxExpansions
     * @return $this
     */
    public function mustMultiMatch(array $keys, $value, $fuzziness = 'AUTO', $maxExpansions = 50): self
    {
        $this->query['must'][] = ['multi_match' => ['fields' => $keys, 'query' => $value, 'fuzziness' => $fuzziness, 'max_expansions' => $maxExpansions]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function mustTerm(string $key, $value): self
    {
        $this->query['must'][] = ['term' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function filterTerm(string $key, $value): self
    {
        $this->query['filter'][] = ['term' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function filterMatch(string $key, $value): self
    {
        $this->query['filter'][] = ['match' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function mustNotTerm(string $key, $value): self
    {
        $this->query['must_not'][] = ['term' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this
     */
    public function mustNotMatch(string $key, $value): self
    {
        $this->query['must_not'][] = ['match' => [trim($key) => $value]];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function shouldTerm(string $key, $value): self
    {
        $this->query['should'] [] = ['term' => [$key => $value]];
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function shouldMatch(string $key, $value): self
    {
        $this->query['should'] [] = ['match' => [$key => $value]];
        return $this;
    }

    /**
     * @param string $key
     * @param $logical
     * @return $this
     */
    public function shouldRange(string $key, array $logical): self
    {
        //$this->query['should'] [] = ['range' => [$key => ['gte' => 75]]];
        $this->query['should'] [] = ['range' => [$key => $logical]];

        return $this;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param int $int
     * @return $this
     */
    public function from(int $int): self
    {
        $this->from = $int;

        return $this;
    }

    /**
     * @param int $minimumMatch
     * @return $this
     */
    public function minimumShouldMatch(int $minimumMatch): self
    {
        $this->minShouldMatch = $minimumMatch;
        return $this;
    }

    /**
     * @param int $boost
     * @return $this
     */
    public function boost(int $boost): self
    {
        $this->boost = $boost;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => $this->bodyQuery(),
        ];
    }

    /**
     * @return array
     */
    public function delete(): array
    {
        return $this->client->deleteByQuery($this->getQuery());
    }

    /**
     * @return Collection
     *
     */
    public function all(): Collection
    {
        $this->mustMatchAll();
        return $this->get();
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return ElasticCollection::make($this->builderQuery->getModel(), $this->getDetail());
    }

    /**
     * @return array
     */
    public function getDetail(): array
    {
        return $this->client->search($this->getQuery());
    }

    /**
     * @param array $sort
     * @return $this
     */
    public function sortWithoutScore(array $sort): self
    {
        $this->sort = [$sort];
        return $this;
    }

    /**
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function sortBy(string $key, string $direction = 'asc'): self
    {
        return $this->sortWithScore([$key => $direction]);
    }


    /**
     * @param string ...$keys
     * @return $this
     */
    public function sortDescByMultiKey(string ...$keys): self
    {
        return $this->sortMultiKeyCreator($keys, 'desc');
    }

    /**
     * @param array $keys
     * @param string $direction
     * @return $this
     */
    private function sortMultiKeyCreator(array $keys, string $direction = 'asc'): self
    {
        $fields = [];
        foreach ($keys as $key) {
            $fields[$key] = $direction;
        }
        return $this->sortWithScore($fields);
    }

    /**
     * @param string ...$keys
     * @return $this
     */
    public function sortAscByMultiKey(string ...$keys): self
    {
        return $this->sortMultiKeyCreator($keys, 'asc');
    }

    /**
     * @param array $sort
     * @return $this
     * @example as such  ['name'=>'asc','age'=>'desc']
     */
    public function sortWithScore(array $sort): self
    {
        $sortRule = [$sort];
        $sortRule[] = '_score';
        $this->sort = $sortRule;
        return $this;
    }

    /**
     * @param $key
     * @param $lat
     * @param $long
     * @param string $distance
     * @return $this
     */
    public function geoDistance($key, $lat, $long, $distance = '50km'): self
    {
        $this->query['filter'][] = [
            'geo_distance' => [
                'distance' => $distance,
                $key => ['lat' => $lat, 'lon' => $long]
            ]
        ];
        return $this;
    }

    /**
     * @param string $key
     * @param array $points
     * @return $this
     */
    public function geoPolygon(string $key, array $points): self
    {
        $this->query['filter'][] = ['geo_polygon' => [
            $key => [
                'points' => $points
            ]
        ]];

        return $this;
    }

    /**
     * @param string $key
     * @return GeoShape
     */
    public function geoShape(string $key): GeoShape
    {
        return new GeoShape($this->query, $key);
    }

    /**
     * @param string $key
     * @return GeoBoundingBox
     */
    public function geoBoundingBox(string $key): GeoBoundingBox
    {
        return new GeoBoundingBox($this->query, $key);
    }

    /**
     * @return \array[][]
     */
    private function bodyQuery(): array
    {
        $body = [
            'query' => [
                'bool' => $this->query,
            ],
        ];

        if ($this->size) {
            $body['size'] = $this->size;
        }
        if ($this->from) {
            $body['from'] = $this->from;
        }

        if ($this->minShouldMatch) {
            $body['query']['bool']['minimum_should_match'] = $this->minShouldMatch;
        }

        if ($this->boost) {
            $body['query']['bool']['boost'] = $this->boost;
        }

        if ($this->sort) {
            $body['sort'] = $this->sort;
        }

        return $body;
    }
}
