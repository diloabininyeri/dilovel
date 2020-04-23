<?php


namespace App\Http;


class FileSize
{


    private int $size;

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