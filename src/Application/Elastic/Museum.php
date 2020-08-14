<?php


namespace App\Application\Elastic;

use App\Components\Elasticsearch\ElasticAggregationQuery;
use App\Components\Elasticsearch\Model;

/**
 * Class Museum
 * @package App\Application\Elastic
 * @example  for location test
 * @method static ElasticAggregationQuery  aggregation();
 */
class Museum extends Model
{

    /**
     * @var string
     */
    protected string $index = 'museums';
}
