<?php


namespace App\Models\Objectable;


use App\Components\ToString;

class UserName
{
    use ToString;

    public function withSurname(): string
    {
        return $this->string . ' sürücü';
    }
}