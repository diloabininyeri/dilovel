<?php


use PHPUnit\Framework\TestCase;

use App\Components\Collection\Collection;

/**
 * Class CollectionTest
 */
class CollectionTest extends TestCase
{

    /**
     *
     */
    public function testCollection(): void
    {
        $collection = new Collection(range(1, 10));
        $this->assertIsIterable($collection);
    }
}
