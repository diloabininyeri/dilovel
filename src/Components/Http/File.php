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

    /**
     * @param string $destination
     * @param string|null $name
     * @return FileUpload
     */
    public function upload(string $destination, string $name=null): FileUpload
    {
        $file= new FileUpload($destination, $this->postedFile(), $name);
        $file->setFile($this->file);
        return  $file->upload();
    }


    /***
     * @return array
     */
    public function toArray(): array
    {
        return  (array) $this->file;
    }
}
