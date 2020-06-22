<?php


namespace App\Components\Image;

/**
 * Class PngResize
 * @package App\Components\Image
 */
class PngResize
{
    private $target;

    /**
     * @param $width
     * @param $height
     * @param $image
     * @return $this
     */
    public function resize(int $width, int $height, string $image):self
    {
        [$imageWidth, $imageHeight] = getimagesize($image);
        $this->target = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $this->target,
            imagecreatefrompng($image),
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
    public function save(string $savePath, int $quality):bool
    {
        imagepng($this->target, $savePath, $quality*0.1);
        return imagedestroy($this->target);
    }
}
