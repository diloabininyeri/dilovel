<?php


namespace App\Components\Env;

use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use JsonException;

/**
 * Class EnvFile
 * @package App\Components\Env
 */
class EnvFile implements ArrayAble, ToJson
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
        $this->envFile = array_filter(file($envFile), fn ($line) =>$line!=="\n");
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
        return array_reduce($this->envFile, [$this, 'reduceArray'], []);
    }

    /**
     * @param array $lines
     * @param $line
     * @return array
     */
    private function reduceArray(array $lines, $line): array
    {
        [$key, $value] = array_map('trim', explode('=', $line));
        $lines[$key] = $value;
        return $lines;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue(string $name)
    {
        return $this->toArray()[$name] ?? null;
    }

    /**
     * @return string|null
     * @throws JsonException
     */
    public function toJson(): ?string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array
     */
    public function toLower(): array
    {
        return array_change_key_case($this->toArray(), CASE_LOWER);
    }
}
