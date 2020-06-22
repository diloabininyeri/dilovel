<?php


namespace App\Components\Image;

/**
 * Class AverageColor
 * @package App\Components\Image
 */
class AverageColor
{

    /**
     * @var string
     */
    private string $image;

    /**
     * AverageColor constructor.
     * @param string $image
     */
    public function __construct(string $image)
    {
        $this->image = $image;
    }

    /**
     * @return array
     */
    private function getImageSize():array
    {
        return getimagesize($this->image);
    }

    /**
     * @return string
     */
    private function getMime():string
    {
        return $this->getImageSize()['mime'];
    }

    /**
     * @return string|string[]
     */
    private function getExtension()
    {
        return pathinfo($this->image, PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    private function createFunction():string
    {
        $extension=$this->getExtension();
        if ($extension === 'jpg') {
            $extension='jpeg';
        }
        return sprintf('imagecreatefrom%s', $extension);
    }

    /**
     * @return ColorConvert
     */
    public function get():ColorConvert
    {
        $avg = $this->createFunction()($this->image);
        [$width, $height] = $this->getImageSize();
        $tmp = imagecreatetruecolor(1, 1);
        imagecopyresampled($tmp, $avg, 0, 0, 0, 0, 1, 1, $width, $height);
        $rgb = imagecolorat($tmp, 0, 0);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        return new ColorConvert(compact('r', 'g', 'b'));
    }
}
