<?php


namespace App\Components\Image;

/**
 * Class GifResize
 * @package App\Components\Image
 */
class GifResize
{
    private $path;

    /**
     * @param $width
     * @param $height
     * @param $image
     * @return $this
     */
    public function resize(int $width, int $height, string $image):GifResize
    {
        [$imageWidth, $imageHeight] = getimagesize($image);
        $this->path = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $this->path,
            imagecreatefromgif($image),
            0,
            0,
            0,
            0,
            $width,
            $height,
            $imageWidth,
            $imageHeight
        );

        return $this;
    }

    /**
     * @param string $savePath
     * @return bool
     */
    public function save(string $savePath):bool
    {
        imagegif($this->path, $savePath);
        return imagedestroy($this->path);
    }
}
