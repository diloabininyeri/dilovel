<?php


namespace App\Components\Image;

/**
 * Class ImageMerge
 * @package App\Components\Image
 */
class ImageMerge
{

    /**
     * @var string
     */
    private string $path;

    /**
     * ImageMerge constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return bool
     */
    public function isImage(): bool
    {
        if (!is_array($this->getImageSize())) {
            return false;
        }
        return !empty($this->getImageSize());
    }

    /**
     * @return array
     */
    public function getImageSize(): array
    {
        return getimagesize($this->path);
    }

    /**
     * @return int
     */
    public function getImageWidth(): int
    {
        [$width,] = $this->getImageSize();
        return $width;
    }

    /**
     * @return int
     */
    public function getImageHeight(): int
    {
        [, $height] = $this->getImageSize();
        return $height;
    }
    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->getImageSize()['mime'];
    }

    /**
     * @return string
     */
    public function getExtension():string
    {
        [,$extension]=explode('/', $this->getMimeType());
        return $extension;
    }
    /**
     * @param ImageMerge $imageMerge
     */
    public function merge(ImageMerge $imageMerge)
    {
        // Create image instances
        $dest = imagecreatefromgif(
            'https://media.geeksforgeeks.org/wp-content/uploads/animateImages.gif'
        );
        $src = imagecreatefromgif(
            'https://media.geeksforgeeks.org/wp-content/uploads/slider.gif'
        );

        // Copy and merge
        imagecopymerge($dest, $src, 0, 10, 0, 0, 500, 200, 50);

        // Output and free from memory
        header('Content-Type: image/gif');
        imagegif($dest);

        imagedestroy($dest);
        imagedestroy($src);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
