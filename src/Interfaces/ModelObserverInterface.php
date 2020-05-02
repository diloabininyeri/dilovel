<?php


namespace App\Interfaces;


use App\Components\Database\Model;

/**
 * Interface ModelObserverInterface
 * @package App\Interfaces
 */
interface ModelObserverInterface
{

    /**
     * @param Model $model
     * @return mixed
     */
    public function updated(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function deleted(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function inserted(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function saved(Model $model);

}