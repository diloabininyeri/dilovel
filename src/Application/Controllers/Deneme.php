<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Http\Request;
use App\Application\Models\Book;
use App\Components\Reflection\DependencyInject;
use App\Components\Routers\CurrentRouter;
use Faker\Factory;

class Deneme
{
    public function index()
    {
        $faker = Factory::create('tr_TR');
        return $faker->firstName.' '.$faker->lastName;
    }
}
