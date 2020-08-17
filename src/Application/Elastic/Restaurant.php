<?php


namespace App\Application\Elastic;

use App\Components\Elasticsearch\Model;

/**
 * Class Restaurant
 * @package App\Application\Elastic
 */
class Restaurant extends Model
{

    /**
     * @var string
     */
    protected string $index = 'restaurants';
}
