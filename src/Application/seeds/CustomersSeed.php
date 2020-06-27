<?php


namespace App\Application\seeds;

use App\Application\Models\Book;
use App\Application\Models\Customers;
use App\Interfaces\SeedInterface;
use Faker\Factory;

class CustomersSeed implements SeedInterface
{

    /** @noinspection DisconnectedForeachInstructionInspection */
    public function create():void
    {
        $faker = Factory::create('tr_TR');
        foreach (range(1, 10) as $id) {
            Customers::create([
                'customer_name' => $faker->name,
                'city_id' =>random_int(1, 82),
                'about'=>$faker->paragraph
            ]);
        }
    }
}
