<?php


namespace App\app\Models\Objectable;


use App\Components\ToString;
use App\Database\ObjectAbleProperty;

class UserPassword extends ObjectAbleProperty
{

    public function strlen()
    {
        return strlen($this->property);
    }
}