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
    public function resize($width, $height, $image):self
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
    public function save($savePath, $quality):bool
    {
        imagepng($this->target, $savePath, $quality*0.1);
        return imagedestroy($this->target);
    }
}
