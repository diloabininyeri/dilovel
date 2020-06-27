<?php


namespace App\Application\seeds\Builder;

use App\Application\seeds\BooksSeed;
use App\Application\seeds\CustomersSeed;
use App\Application\seeds\UsersSeed;

/**
 * Class DatabaseSeeder
 * @package App\Application\seeds\Builder
 */
class DatabaseSeeder
{
    /**
     * @return array|string[]
     */
    public function seeds(): array
    {
        return [
            BooksSeed::class,
            UsersSeed::class,
            CustomersSeed::class
        ];
    }
}
