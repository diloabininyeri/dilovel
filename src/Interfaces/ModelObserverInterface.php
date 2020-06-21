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
     * @param Model $oldModel
     * @return mixed
     */
    public function updated(Model $model, Model $oldModel);

    /**
     * @param Model $model
     * @return mixed
     */
    public function deleted(Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function created(Model $model);
}
