<?php


namespace App\Application\Elastic;

use App\Components\Collection\Collection;
use App\Components\Elasticsearch\ElasticAggregationQuery;
use App\Components\Elasticsearch\ElasticBoolQuery;
use App\Components\Elasticsearch\ElasticScrollQuery;
use App\Components\Elasticsearch\Model;

/**
 * Class ElasticModelExample
 * @package App\Application\Elastic
 * @method static exists()
 * @method static Collection all()
 * @method static self find($id)
 * @method static ElasticBoolQuery  bool();
 * @method static ElasticScrollQuery  scroll();
 * @method static Collection  searchWithSql(string $sqlQuery);
 * @method static ElasticAggregationQuery  aggregation();
 * @construct(deneme)
 * @property $id
 * @property $testField
 */
class ElasticSearchModel extends Model
{
    /**
     * @var string
     */
    protected string $index='users';

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTestField()
    {
        return $this->testField;
    }
}
