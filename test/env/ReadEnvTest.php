<?php


use App\Components\Env\EnvFile;
use PHPUnit\Framework\TestCase;

class ReadEnvTest extends TestCase
{

    public function testGetValue()
    {
        $file = new EnvFile('.env');
        $value = $file->getValue('TEST_EXAMPLE');

        $this->assertEquals(123456, $value);
    }

}