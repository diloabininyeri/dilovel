<?php


namespace App\Components\Image;

/**
 * Class JpegResize
 * @package App\Components\Image
 */
class JpegResize
{
    private $path;

    /**
     * @param $width
     * @param $height
     * @param $image
     * @return $this
     */
    public function resize(int $width, int $height, string $image): self
    {
        [$imageWidth, $imageHeight] = getimagesize($image);
        $this->path = imagecreatetruecolor($width, $height);
        $source = imagecreatefromjpeg($image);
        imagecopyresampled(
            $this->path,
            $source,
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
     * @param $savePath
     * @param $quality
     * @return bool
     */
    public function save($savePath, $quality): bool
    {
        imagejpeg($this->path, $savePath, $quality);
        return imagedestroy($this->path);
    }
}
