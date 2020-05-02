<?php


namespace App\Application\Observer;


use App\Components\Database\Model;
use App\Interfaces\ModelObserverInterface;

class UserObserver implements ModelObserverInterface
{

    public function updated(Model $model)
    {
        // TODO: Implement updated() method.
    }

    public function deleted(Model $model)
    {
        // TODO: Implement deleted() method.
    }

    public function inserted(Model $model)
    {
        // TODO: Implement inserted() method.
    }

    public function saved(Model $model)
    {
        // TODO: Implement saved() method.
    }
}