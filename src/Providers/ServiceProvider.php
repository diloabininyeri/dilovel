<?php


namespace App\Providers;


use App\Http\Request;
use App\Macro\ModelMacro;

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
        $request=new Request();
        $request->session()->set('city','urfa');
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
        // TODO: Implement register() method.
    }
}