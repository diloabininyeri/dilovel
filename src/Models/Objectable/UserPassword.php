<?php


namespace App\Models\Objectable;


use App\Components\ToString;

class UserPassword
{
    use ToString;

    public function get()
    {
        return $this->string;
    }

}