<?php


namespace App\Components\Elasticsearch;

use App\Components\Collection\Collection;
use Elasticsearch\Client;
use Exception;
use stdClass;
use Throwable;

/**
 * Class ElasticScrollQuery
 * @package App\Components\Elasticsearch
 */
class ElasticScrollQuery
{

    /**
     * @var ElasticBuilderQuery
     */
    private ElasticBuilderQuery $builderQuery;


    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var array
     */
    private array $query = [];

    /**
     * @var string|null
     */
    private ?string $scrollTime = null;

    /**
     * @var int|null
     */
    private ?int  $size = null;

    /**
     * ElasticScrollQuery constructor.
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
    public function matchAll(): self
    {
        $this->query['match_all'] = new stdClass();
        return $this;
    }

    /**
     * @param string $key
     * @param array $logical
     * @return $this
     */
    public function range(string $key, array $logical):self
    {
        $this->query['range']=[
            $key=>$logical
        ];
        return $this;
    }

    /**
     * @param string $time
     * @return $this
     */
    public function life(string $time = '1m'): self
    {
        $this->scrollTime = $time;
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
     * @return array
     */
    public function getQuery(): array
    {
        $query= [
            'index' => $this->builderQuery->getModel()->getIndex(),
            'body' => $this->getBodyQuery()
        ];
        if ($this->size) {
            $query['size'] = $this->size;
        }
        if ($this->scrollTime) {
            $query['scroll'] = $this->scrollTime;
        }

        return $query;
    }

    /**
     * @return array
     */
    private function getBodyQuery(): array
    {
        return [
            'query' => $this->query
        ];
    }

    /**
     * @return ElasticScrollParse
     */
    public function get():ElasticScrollParse
    {
        return new ElasticScrollParse($this->client->search($this->getQuery()), $this);
    }

    /**
     * @return string
     */
    public function generateId():string
    {
        if (!$this->scrollTime) {
            $this->life('1m');
        }
        if (empty($this->query)) {
            $this->matchAll();
        }
        return $this->get()->id();
    }


    /**
     * @param string $scrollId
     * @param string $life
     * @return mixed
     */
    public function isAlive(string $scrollId, string $life='1m'):bool
    {
        try {
            $scrollQuery = [
                'scroll_id' => $scrollId,
                'scroll' => $life,
            ];

            $result = $this->client->scroll($scrollQuery);
            return isset($result['hits']['hits']);
        } catch (Exception $exception) {
            return false;
        }
    }
    /**
     * @param string $scrollId
     * @return bool
     */
    public function deleteId(string $scrollId):bool
    {
        try {
            $clearScroll= $this->client->clearScroll([
                'scroll_id'=>[$scrollId]
            ]);
        } catch (Throwable $exception) {
            return false;
        } finally {
            return (bool)($clearScroll['succeeded'] ?? false);
        }
    }
    /**
     * @return ElasticBuilderQuery
     */
    public function getBuilderQuery(): ElasticBuilderQuery
    {
        return $this->builderQuery;
    }

    /**
     * @param string $scrollId
     * @param string $life
     * @return Collection
     */
    public function lazyLoad(string $scrollId, string $life='1m'):Collection
    {
        $scrollQuery = [
            'scroll_id' => $scrollId,
            'scroll' => $life,
        ];
        $result = $this->client->scroll($scrollQuery);
        return ElasticCollection::make($this->builderQuery->getModel(), $result);
    }
}
