<?php


namespace App\Models\Objectable;


use App\Components\ToString;

class UserPassword extends ObjectAbleProperty
{

    public function strlen()
    {
        return strlen($this->property);
    }
}