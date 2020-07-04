<?php


namespace App\Components\Lang;

use App\Components\Arr\DotNotation;
use App\Components\Http\Session;

/**
 * Class Lang
 * @package App\Components\Lang
 */
class Lang
{
    /**
     * @var array
     */
    private static array $langFiles = [];
    /**
     * @var string
     */
    private static string $sessionName = 'system_language';

    /**
     * @param string $folderName
     * @return bool
     */
    public static function set(string $folderName = 'en'): bool
    {
        return Session::getInstance()->set(self::$sessionName, $folderName);
    }

    /**
     * @param string $dotNotation
     * @param null $default
     * @return string
     */
    public static function get(string $dotNotation, $default=null): ?string
    {
        [$file, $dot] = explode('.', $dotNotation, 2);
        $path = sprintf('src/Application/Lang/%s/%s.php', self::getLanguageName(), $file);
        if (!isset(self::$langFiles[$path])) {
            self::$langFiles[$path]=require $path;
        }
        return DotNotation::getInstance()->getValueByKey($dot, self::$langFiles[$path], $default);
    }

    /**
     * @return bool
     */
    public static function isExistSessionLanguage():bool
    {
        return Session::getInstance()->exists(self::$sessionName);
    }

    /**
     * @return mixed|string
     */
    public static function getLanguageName()
    {
        return Session::getInstance()->get(self::$sessionName) ?? 'en';
    }
}
