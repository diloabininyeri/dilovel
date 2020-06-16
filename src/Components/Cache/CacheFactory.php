<?php


namespace App\Components\Cache;

use App\Components\Cache\Memcache\Memcache;
use App\Components\Cache\Redis\RedisClient;
use App\Components\NullObject;

/**
 * Class Cache
 * @package App\Components\Cache
 */
class CacheFactory
{

    /**
     * @var string
     */
    private string $clientName;

    /**
     * @var array|string[]
     */


    /**
     * Cache constructor.
     * @param string $clientName
     */
    public function __construct(string $clientName='redis')
    {
        $this->clientName = $clientName;
    }


    /**
     * @return object|NullObject
     */
    public function getInstance(): object
    {
        if (in_array($this->clientName, $this->allowedClients(), true)) {
            $class=$this->clients()[$this->clientName];
            return new $class;
        }
        return new NullObject();
    }

    /**
     * @return array
     */
    private function clients(): array
    {
        return Clients::CLASSES;
    }

    /**
     * @return array
     */
    private function allowedClients():array
    {
        return array_keys($this->clients());
    }
}
