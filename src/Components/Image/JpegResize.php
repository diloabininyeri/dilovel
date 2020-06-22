<?php


namespace App\Components\Image;

/**
 * Class JpegResize
 * @package App\Components\Image
 */
class JpegResize
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
    public function resize(int $width, int $height, string $image, bool $isWillDeleteOldImage): self
    {
        $this->isWillDeleteOldImage=$isWillDeleteOldImage;
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
        $createNewImage=imagejpeg($this->path, $this->resizePath($savePath), $quality);
        if ($createNewImage && $this->isWillDeleteOldImage) {
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
