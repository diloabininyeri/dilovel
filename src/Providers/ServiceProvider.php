<?php


namespace App\Providers;

use App\Application\Models\Book;
use App\Application\Models\Users;
use App\Application\Observer\UserObserver;
use App\Components\Database\ModelMacro;

/**
 * @property  $collection
 */
class ServiceProvider implements ProviderInterface
{

    /**
     *
     */
    public function boot():void
    {
        ModelMacro::addMethod('upper', function ($keys) {
            return array_map(static function ($collection) use ($keys) {
                foreach ($keys as $key) {
                    $collection->$key = strtoupper($collection->$key);
                }
                return $collection;
            }, $this->collection);
        });
    }

    /**
     *
     */
    public function register(): void
    {
        Users::observe(UserObserver::class);
    }
}
