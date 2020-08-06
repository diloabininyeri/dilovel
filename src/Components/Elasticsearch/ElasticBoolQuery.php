<?php


namespace App\Components\Elasticsearch;

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
    private array $query=[];

    /**
     * @var int|null
     */
    private ?int $size = null;

    /**
     * @var int|null
     */
    private ?int $from = null;

    /**
     * @var int|null
     */
    private ?int $minShouldMatch=null;


    /**
     * @var int|null
     */
    private ?int $boost=null;
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
        $this->client=Elastic::connection();
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
    public function mustMultiMatch(array $keys, $value, $fuzziness='AUTO', $maxExpansions=50):self
    {
        $this->query['must'][] = ['multi_match' => ['fields'=>$keys,'query'=>$value,'fuzziness'=>$fuzziness,'max_expansions'=>$maxExpansions]];

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
    public function minimumShouldMatch(int $minimumMatch):self
    {
        $this->minShouldMatch=$minimumMatch;
        return $this;
    }

    /**
     * @param int $boost
     * @return $this
     */
    public function boost(int $boost):self
    {
        $this->boost=$boost;
        return  $this;
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
    public function delete():array
    {
        return $this->client->deleteByQuery($this->getQuery());
    }
    /**
     * @return array
     */
    public function get(): array
    {
        $records=$this->client->search($this->getQuery());
        return ModelMapper::make($this->builderQuery->getModel(), $records);
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
            $body['query']['bool']['minimum_should_match']=$this->minShouldMatch;
        }

        if ($this->boost) {
            $body['query']['bool']['boost']=$this->boost;
        }
        return $body;
    }
}
