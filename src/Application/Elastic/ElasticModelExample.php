<?php


namespace App\Application\Elastic;

use App\Components\Collection\Collection;
use App\Components\Elasticsearch\Model;

/**
 * Class ElasticModelExample
 * @package App\Application\Elastic
 * @method static exists()
 * @method static Collection all()
 * @construct(deneme)
 */
class ElasticModelExample extends Model
{
    /**
     * @var string
     */
    protected string $index='my_index';

    /**
     * @var string
     */
    protected string $primaryKey='id';
}
