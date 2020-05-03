<?php


namespace App\Application\Models\Objectable;

use App\Components\Database\ObjectAbleProperty;

class UserPassword extends ObjectAbleProperty
{
    public function strlen()
    {
        return strlen($this->property);
    }
}
