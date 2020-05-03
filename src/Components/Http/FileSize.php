<?php


namespace App\Components\Http;

/**
 * Class FileSize
 * @package App\Http
 */
class FileSize
{


    /**
     * @var int
     */
    private int $size;

    /**
     * FileSize constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
    }

    /**
     * @return float|int
     */
    public function asKilobyte()
    {
        return $this->size/1024;
    }

    /**
     * @return float|int
     */
    public function asMegabyte()
    {
        return $this->size/(1024*1024);
    }


    /**
     * @return int
     */
    public function asByte()
    {
        return $this->size;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->size;
    }
}
