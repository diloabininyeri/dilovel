<?php


use App\Components\Env\EnvFile;
use PHPUnit\Framework\TestCase;

/**
 * Class ReadEnvTest
 */
class ReadEnvTest extends TestCase
{

    /**
     * @var EnvFile
     */
    private $envFile;

    /**
     *
     */
    public function setUp(): void
    {
        $this->envFile = new EnvFile('.env');
        parent::setUp();
    }

    /**
     *
     */
    public function testGetValue()
    {
        $value = $this->envFile->getValue('TEST_EXAMPLE');

        $this->assertEquals(123456, $value);
    }

    /**
     *
     */
    public function testToArray()
    {
        $this->assertIsArray($this->envFile->toArray());
    }


    /**
     * @throws JsonException
     */
    public function testToJson()
    {
        $this->assertJson($this->envFile->toJson());
    }
}
