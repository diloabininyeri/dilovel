<?php


namespace App\Components\Image;

use App\Components\NullObject;

/**
 * Class Image
 * @package App\Components\Image
 */
class Image
{
    /**
     * @var string
     */
    private string $imagePath;
    /**
     * @var Resize
     */
    private Resize $resize;


    public function __construct(string $imagePath)
    {
        $this->resize = new Resize();
        $this->imagePath = $imagePath;
    }

    /**
     * @param $width
     * @param $height
     * @return $this
     */
    public function resize(int $width, int $height): self
    {
        $this->resize->resize(
            $width,
            $height,
            mime_content_type($this->imagePath),
            $this->imagePath
        );
        return $this;
    }

    /**
     * @param int $percent
     * @return $this
     */
    public function resizeByRatio(int $percent):self
    {
        [$imageWidth, $imageHeight] = getimagesize($this->imagePath);
        return $this->resize($imageWidth*($percent/100), $imageHeight*($percent/100));
    }


    /**
     * @param string $imagePath
     * @return object|self
     */
    public static function load(string $imagePath): object
    {
        if (file_exists($imagePath)) {
            return new self($imagePath);
        }
        return new NullObject();
    }


    /**
     * @param $savePath
     * @param int $quality
     * @return mixed
     */
    public function save(string $savePath, $quality = 100)
    {
        return $this->resize->save($savePath, $quality);
    }
}
