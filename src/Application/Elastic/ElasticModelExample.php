<?php


namespace App\Application\Elastic;

use App\Components\Collection\Collection;
use App\Components\Elasticsearch\Model;

/**
 * Class ElasticModelExample
 * @package App\Application\Elastic
 * @method static exists()
 * @method static Collection all()
 * @method static self find($id)
 * @construct(deneme)
 * @property $id
 * @property $testField
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
