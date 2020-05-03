<?php /** @noinspection PhpUnused */


namespace App\Components\Http;

use App\Interfaces\ArrayAble;

/**
 * Class PostedFile
 * @package App\Http
 */
class PostedFile implements ArrayAble
{


    /**
     * @var object
     */
    private object $file;

    /**
     * PostedFile constructor.
     * @param object $file
     */
    public function __construct(object $file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->file->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->file->type;
    }

    /**
     * @return FileSize
     */
    public function getSize(): FileSize
    {
        return new FileSize($this->file->size);
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->file->tmp_name;
    }

    /**
     * @return mixed
     */
    public function error()
    {
        return $this->file->error;
    }

    /**
     * @return string|string[]
     */
    public function getExtension()
    {
        return pathinfo($this->getName(), PATHINFO_EXTENSION);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->file->extension = $this->getExtension();
        return (array)$this->file;
    }
}
