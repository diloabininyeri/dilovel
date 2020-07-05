<?php


namespace App\Components\Http;

use SplFileInfo;
use SplFileObject;

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
     * @param array $file
     */
    public function __construct(array $file)
    {
        $this->file = $file;
    }

    /**
     * @return PostedFile
     */
    public function postedFile(): PostedFile
    {
        return new PostedFile((object)$this->file);
    }

    /**
     * @return bool
     */
    public function isImage():bool
    {
        return (bool) exif_imagetype($this->file['tmp_name']);
    }

    /**
     * @return string
     */
    public function getMimeType():?string
    {
        if (file_exists($this->file['tmp_name'])) {
            return mime_content_type($this->file['tmp_name']);
        }
        return null;
    }

    /**
     * @return SplFileInfo
     */
    public function getInfo(): SplFileInfo
    {
        return new SplFileInfo($this->file['tmp_name']);
    }

    /**
     * @return SplFileObject
     */
    public function getObject():SplFileObject
    {
        return new SplFileObject($this->file['tmp_name']);
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
        $file= new FileUpload(trim($destination, '/'), $this->postedFile(), $this->file, $name);
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
