<?php


namespace App\Components\Image;

use App\Components\Exceptions\ImageExtensionNotSupported;

/**
 * Class Resize
 * @package App\Components\Image
 */
class Resize
{
    /**
     * @var object
     */
    private object $resize;

    /**
     * @var array|string[]
     */
    private array $allowExtensions=['png','jpg','jpeg','gif'];

    /**
     * @var array|string[]
     */
    private array $resizeClasses=[
        'png'=>PngResize::class,
        'jpg'=>JpegResize::class,
        'jpeg'=>JpegResize::class,
        'gif'=>GifResize::class,
    ];


    /**
     * @param int $width
     * @param int $height
     * @param $fileMimeType
     * @param string $imagePath
     * @param bool $willDeleteOldImage
     * @return $this
     */
    public function resize(int $width, int  $height, $fileMimeType, string $imagePath, bool $willDeleteOldImage): self
    {
        $extension = strtolower(explode("/", $fileMimeType)[1]);
        if (!in_array(strtolower($extension), $this->allowExtensions, true)) {
            throw new ImageExtensionNotSupported("not supported $extension image type");
        }
        $class = $this->resizeClasses[$extension];
        $this->resize=(new $class())->resize($width, $height, $imagePath, $willDeleteOldImage);
        return $this;
    }

    /**
     * @param $savePath
     * @param int $quality
     * @return mixed
     */
    public function save(string $savePath, int $quality)
    {
        return $this->resize->save($savePath, $quality);
    }
}
