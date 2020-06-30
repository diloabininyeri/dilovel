<?php


namespace App\Application\Observer;

use App\Application\Models\Users;
use App\Components\Database\Model;
use App\Components\Database\ObserveStorage;
use App\Interfaces\ModelObserverInterface;

class UserObserver implements ModelObserverInterface
{
    public function updated($model, $oldModel)
    {
        $model->name;
        $oldModel->name;
    }

    public function deleted(Model $model)
    {
        echo $model->name.' deleted';
    }

    public function created(Model $model)
    {
        echo $model->name . ' cretaed';
    }
}
