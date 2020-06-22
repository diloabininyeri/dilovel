<?php


namespace App\Components\Image;

/**
 * Class GifResize
 * @package App\Components\Image
 */
class GifResize
{
    private $path;

    private bool $isWillDeleteOldImage;

    /**
     * @param int $width
     * @param int $height
     * @param string $image
     * @param bool $isWillDeleteOldImage
     * @return $this
     */
    public function resize(int $width, int $height, string $image, bool $isWillDeleteOldImage):GifResize
    {
        $this->isWillDeleteOldImage=$isWillDeleteOldImage;
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
        $createGif=imagegif($this->path, $savePath);
        if ($createGif && $this->isWillDeleteOldImage) {
            unlink($savePath);
        }
        return imagedestroy($this->path);
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
