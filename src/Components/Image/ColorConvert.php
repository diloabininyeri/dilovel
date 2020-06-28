<?php


namespace App\Components\Image;

/**
 * Class ColorConvert
 * @package App\Components\Image
 */
class ColorConvert
{

    /**
     * @var array
     */
    private array $rgb;

    /**
     * ColorConvert constructor.
     * @param array $rgb
     */
    public function __construct(array $rgb)
    {
        $this->rgb = $rgb;
    }
    /**
     * @return array
     */
    public function getRgb(): array
    {
        return $this->rgb;
    }
    /**
     * @return string
     */
    public function toHex(): string
    {
        return  sprintf("#%02x%02x%02x", $this->rgb['r'], $this->rgb['g'], $this->rgb['b']);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('rgb(%d,%d,%d)', $this->rgb['r'], $this->rgb['g'], $this->rgb['b']);
    }


    public function toHumanize():?string
    {
        $color= (new ColorHumanize())->name($this->toHex());
        return $color['name'] ?? null;
    }
    /**
     * @return string
     */
    public function toRgb():string
    {
        return $this->toString();
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toHex();
    }
}
