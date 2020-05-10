<?php


namespace App\Components\Http;


/**
 * Class FileUpload
 * @package App\Components\Http
 */
class FileUpload
{

    /**
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @var string|null
     */
    private ?string $destination;

    /**
     * @var PostedFile
     */
    private PostedFile $postedFile;

    /**
     * @var string|null
     */
    private ?string $uploadedFile = null;

    /**
     * FileUpload constructor.
     * @param string $destination
     * @param PostedFile $postedFile
     * @param string|null $name
     */
    public function __construct(string $destination, PostedFile $postedFile, ?string $name = null)
    {
        $this->name = $name;
        $this->destination = $destination;
        $this->postedFile = $postedFile;
    }

    /**
     * @return $this
     */
    public function upload(): self
    {
        $path = $this->generateFilePath();
        if (move_uploaded_file($_FILES[$this->name]['tmp_name'], $path)) {
            $this->uploadedFile = $path;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    private function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    private function generateFileName(): string
    {
        return uniqid('file', true) . '.' . $this->postedFile->getExtension();
    }

    /**
     * @return string
     */
    private function generateFilePath(): string
    {
        return sprintf('%s%s%s', $this->getDestination(), DIRECTORY_SEPARATOR, $this->generateFileName());
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->uploadedFile;

    }
}