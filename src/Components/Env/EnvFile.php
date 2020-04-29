<?php


namespace App\Components\Env;


/**
 * Class EnvFile
 * @package App\Components\Env
 */
class EnvFile
{
    /**
     * @var array|false
     *
     */
    private array $envFile;

    /**
     * EnvFile constructor.
     * @param string $envFile
     */

    public function __construct(string $envFile)
    {
        $this->envFile = file($envFile);
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->envFile;
    }

    /**
     * @param int $number
     * @return mixed|string
     */
    public function getLine(int $number)
    {
        return $this->envFile[$number + 1];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {

        return array_reduce($this->envFile, static function ($array, $line) {
            $line = explode('=', $line);
            [$key, $value] = array_map('trim', $line);
            $array[$key] = $value;

            return $array;

        }, []);


    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue(string $name)
    {
        return $this->toArray()[$name];
    }
}