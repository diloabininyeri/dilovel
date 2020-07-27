<?php


namespace App\Components\Elasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class Elastic
 * @package App\Components\Elasticsearch
 */
class Elastic
{


    /**
     * @return Client
     */
    public static function connection(): Client
    {
        return ClientBuilder::create()->build();
    }
}
