<?php
namespace App\Components\Http;

use App\Components\Image\Image;
use SplFileInfo;
use SplFileObject;

/**
 * Class FileUpload
 * @package App\Components\Http
 */
class FileUpload
{

    /**
     * @var string|null
     */
    private ?string $name;

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

    private array $file;

    /**
     * FileUpload constructor.
     * @param string $destination
     * @param PostedFile $postedFile
     * @param $file
     * @param string|null $name
     */
    public function __construct(string $destination, PostedFile $postedFile, array $file, ?string $name = null)
    {
        $this->setFile($file);
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
        if (move_uploaded_file($this->getFile()['tmp_name'], public_path($path))) {
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
        return $this->generateName() ? : uniqid('file', true) . '.' . $this->postedFile->getExtension();
    }

    /**
     * @return string|null
     */
    private function generateName():?string
    {
        if ($this->name) {
            return $this->name . '.' . $this->postedFile->getExtension();
        }
        return null;
    }

    /**
     * @return string
     */
    private function generateFilePath(): string
    {
        return sprintf('%s%s%s_%s', $this->getDestination(), DIRECTORY_SEPARATOR, date('Y_m_d'), $this->generateFileName());
    }

    /**
     * @param mixed $file
     * @return FileUpload
     */
    private function setFile(array $file): FileUpload
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return SplFileInfo
     * @noinspection PhpUnused
     */
    public function splInfo():SplFileInfo
    {
        return new SplFileInfo(public_path($this->getUploadedFile()));
    }

    /**
     * @return SplFileObject
     * @noinspection PhpUnused
     */
    public function splObject():SplFileObject
    {
        return new SplFileObject(public_path($this->generateName()));
    }

    /**
     * @return bool
     * @noinspection PhpUnused
     */
    public function deleteUploadFile():bool
    {
        return unlink(public_path($this->getUploadedFile()));
    }
    /**
     * @return mixed
     */
    private function getFile()
    {
        return $this->file;
    }

    /**
     * @return string|null
     */
    public function getUploadedFile(): ?string
    {
        return $this->uploadedFile;
    }


    public function image()
    {
        return  new Image($this->uploadedFile);
    }

    /**
     * @return string|null
     * @noinspection MagicMethodsValidityInspection
     */
    public function __toString()
    {
        return $this->uploadedFile;
    }
}
