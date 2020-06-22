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


    private bool $isWillRemovedOldImage = false;

    public function __construct(string $imagePath)
    {
        $this->resize = new Resize();
        $this->imagePath = $imagePath;
    }

    /**
     * @return $this
     */
    public function removeOldImage():self
    {
        $this->isWillRemovedOldImage = true;
        return $this;
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
            $this->imagePath,
            $this->isWillRemovedOldImage
        );
        return $this;
    }

    /**
     * @param int $percent
     * @return $this
     */
    public function resizeByRatio(int $percent): self
    {
        [$imageWidth, $imageHeight] = getimagesize($this->imagePath);
        return $this->resize($imageWidth * ($percent / 100), $imageHeight * ($percent / 100));
    }


    /**
     * @param string $imagePath
     * @return object|self
     */
    public static function load(string $imagePath): object
    {
        $imagePath = public_path($imagePath);
        if (file_exists($imagePath)) {
            return new self($imagePath);
        }
        return new NullObject();
    }


    /**
     * @param string $image
     * @return ColorConvert
     */
    public static function getAverageColor(string $image): ColorConvert
    {
        return (new AverageColor($image))->get();
    }
    /**
     * @param $savePath
     * @param int $quality
     * @return mixed
     */
    public function save(string $savePath, $quality = 100)
    {
        return $this->resize->save(public_path($savePath), $quality);
    }
}
