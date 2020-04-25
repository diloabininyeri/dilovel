<?php


namespace App\app\Models;


use App\Database\Model;

class Book extends Model
{

    protected string $table='books';

    protected string $connection='default';


    protected array $hidden=['name'];


    public function getBookName()
    {
        return strtoupper($this->name);
    }

    public function getDefaultName()
    {
        return 'no names';
    }
}