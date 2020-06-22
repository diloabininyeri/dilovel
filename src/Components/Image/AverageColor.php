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
     * @return array
     */
    private function calculateAvgColor():array
    {
        $avg = $this->createFunction()($this->image);
        [$width, $height] = $this->getImageSize();
        $tmp = imagecreatetruecolor(1, 1);
        imagecopyresampled($tmp, $avg, 0, 0, 0, 0, 1, 1, $width, $height);
        $rgb = imagecolorat($tmp, 0, 0);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        return compact('r', 'g', 'b');
    }
    /**
     * @return ColorConvert
     */
    public function get():ColorConvert
    {
        return new ColorConvert($this->calculateAvgColor());
    }
}
