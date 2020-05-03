<?php


use PHPUnit\Framework\TestCase;

class ConfigReadTest extends TestCase
{
    public function testDotNotation()
    {
        $version=config('test.php.version');

        $this->assertEquals($version, 7.4);
    }
}
