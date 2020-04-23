<?php


namespace App\Models;


class Book extends Model
{

    protected $table='books';


    protected $hidden=['name'];


    public function getBookName()
    {

        return strtoupper($this->name);
    }

    public function getDefaultName()
    {
        return 'no names';
    }
}