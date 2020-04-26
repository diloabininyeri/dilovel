<?php


namespace Bin\Components;


/**
 * Class Color
 * @package Bin\Components
 */
class Color
{
    /**
     * @var ColorConsole
     */
    private static ?ColorConsole $color=null;

    /**
     * @return ColorConsole
     */
    public static function consoleText(): ColorConsole
    {
        if(!self::$color) {
            self::$color = new ColorConsole();
        }
        return self::$color;
    }


}