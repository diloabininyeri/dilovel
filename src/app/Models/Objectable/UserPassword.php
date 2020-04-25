<?php


namespace App\app\Models\Objectable;


use App\Components\Database\ObjectAbleProperty;

class UserPassword extends ObjectAbleProperty
{

    public function strlen()
    {
        return strlen($this->property);
    }
}