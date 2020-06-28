<?php


namespace App\Components\Http\Response;

/**
 * Class ResponseImage
 * @package App\Components\Http\Response
 */
class ResponseImage
{
    /**
     * @var null
     */
    private $data;

    /**
     * @var string|null
     */
    private ?string $mimeType=null;


    /**
     * @var string
     */
    private string $path;

    /**
     * @param string $path
     * @return $this
     */
    public function path(string $path): self
    {
        $this->data = file_get_contents($this->path = $path);
        return $this;
    }

    /**
     * @return mixed|string
     */
    private function getMimeType()
    {
        return $this->mimeType ?: getimagesize($this->path)['mime'];
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setMimeType(string $type): self
    {
        $this->mimeType = $type;
        return $this;
    }

    /**
     * @return null
     */
    public function print()
    {
        header("Content-type:$this->mimeType");
        return $this->data;
    }
}
