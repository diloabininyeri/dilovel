<?php


namespace App\Application\Elastic;

use App\Components\Collection\Collection;
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
 * @construct(deneme)
 * @property $id
 * @property $testField
 */
class ElasticModelExample extends Model
{
    /**
     * @var string
     */
    protected string $index='users';

    /**
     * @var string
     */
    protected string $primaryKey='id';

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
