<?php


namespace App\Application\seeds;

use App\Application\Models\Book;
use App\Interfaces\SeedInterface;
use Faker\Factory;

class BooksSeed implements SeedInterface
{
    public function create():void
    {
        foreach (range(1, 10) as $id) {
            $faker = Factory::create('tr_TR');
            Book::create([
                'name' => $faker->domainName,
                'user_id' =>$faker->randomDigit,
            ]);
        }
    }
}
