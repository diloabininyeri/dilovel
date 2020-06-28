<?php


namespace App\Components\Image;

/**
 * Class Color
 * @package App\Components\Image
 */
class Color
{

    /**
     * @param string $rgb
     * @return string
     */
    public static function toHexFromStringRgb(string $rgb): string
    {
        sscanf($rgb, 'rgb(%d,%d,%d)', $red, $green, $blue);
        return self::toHexFromRgb($red, $green, $blue);
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return string
     */
    public static function toHexFromRgb(int $red, int $green, int $blue): string
    {
        return sprintf("#%02x%02x%02x", $red, $green, $blue);
    }

    public static function toRgbArrayFromHex(string $hex): array
    {
        [$red, $green, $blue] = sscanf($hex, "#%02x%02x%02x");
        return compact('red', 'green', 'blue');
    }
    /**
     * @param string $hex
     * @return string
     */
    public function toRgbStringFromHex(string $hex):string
    {
        $rgb = self::toRgbArrayFromHex($hex);
        return "rgb({$rgb['red']}, {$rgb['green']},{$rgb['blue']})";
    }
    /**
     * @param string $rgb
     * @return array
     */
    public static function rgbParse(string $rgb): array
    {
        sscanf($rgb, 'rgb(%d,%d,%d)', $red, $green, $blue);
        return compact('red', 'green', 'blue');
    }
}
