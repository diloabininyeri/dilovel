<?php


namespace App\Components\Database;

/**
 * Class ObserverFire
 * @package App\Components\Database
 */
class ObserverFire
{


    /**
     * @param Model $model
     */
    public static function updated(Model $model): void
    {
        if ($model->getObserveClass() && isset(ObserveStorage::get($model)[0])) {
            $observeClass = $model->getObserveClass();
            (new $observeClass)->updated($model, ObserveStorage::get($model)[0]);
        }
    }
    /**
     * @param Model $model
     */
    public static function created(Model $model): void
    {
        $observeClass = $model->getObserveClass();
        if ($observeClass) {
            (new $observeClass)->created($model);
        }
    }

    /**
     * @param Model $model
     */
    public static function deleted(Model $model): void
    {
        $observeClass = $model->getObserveClass();
        if ($observeClass) {
            (new $observeClass)->deleted($model);
        }
    }
}
