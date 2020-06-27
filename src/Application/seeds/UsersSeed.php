<?php


namespace App\Application\seeds;

use App\Application\Models\Users;
use App\Components\Auth\Hash\Hash;
use App\Interfaces\SeedInterface;
use Faker\Factory;

class UsersSeed implements SeedInterface
{
    public function create(): void
    {
        foreach (range(1, 10) as $id) {
            $faker = Factory::create('tr_TR');
            Users::create([
                'name' => $faker->firstName,
                'password' => Hash::make(123456),
                'surname' => $faker->lastName,
                'country' => 90,
                'email' => $faker->email,
            ]);
        }
    }
}
