<?php


namespace App\Components\Image;

/**
 * Class PngResize
 * @package App\Components\Image
 */
class PngResize
{
    private $target;

    private bool $isWillDeleteOldImage;
    /**
     * @param $width
     * @param $height
     * @param $image
     * @return $this
     */
    public function resize(int $width, int $height, string $image, bool $isWillDeleteOldImage):self
    {
        $this->isWillDeleteOldImage=$isWillDeleteOldImage;
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
        $createNewImage=imagepng($this->target, $savePath, $quality*0.1);
        if ($createNewImage && $this->isWillDeleteOldImage) {
            unlink($savePath);
        }
        return imagedestroy($this->target);
    }

    /**
     * @param string $path
     * @return string
     */
    private function resizePath(string $path):string
    {
        $pathInfo=pathinfo($path);
        $newPath= $pathInfo['dirname'].'/resize_' . $pathInfo['basename'];
        touch($newPath);
        return $newPath;
    }
}
