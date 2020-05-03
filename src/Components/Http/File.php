<?php


namespace App\Components\Http;

/**
 * Class File
 * @package App\Http
 */
class File
{

    /**
     * @var array|mixed
     */
    private array $file;

    /**
     * File constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $_FILES[$file];
    }

    /**
     * @return PostedFile
     */
    public function postedFile(): PostedFile
    {
        return new PostedFile((object)$this->file);
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }


    /***
     * @return array
     */
    public function toArray(): array
    {
        return  (array) $this->file;
    }
}
