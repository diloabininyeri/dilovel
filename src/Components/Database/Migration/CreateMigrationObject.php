<?php


namespace App\Components\Database\Migration;

use App\Components\Reflection\PhpFileParser;
use function Composer\Autoload\includeFile;

/**
 * Class CreateMigrationObject
 * @package App\Components\Database\Migration
 */
class CreateMigrationObject
{

    /**
     * @param string $file
     * @return mixed
     */
    public static function fromFile(string $file)
    {
        includeFile($file);
        $phpParser = new PhpFileParser();
        return $phpParser->getClassObjectFromFile($file);
    }
}
