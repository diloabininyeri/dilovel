<?php


namespace App\Components\File;

use SimpleXLSX;

/**
 * Class Excel
 * @package App\Components\File
 */
class Excel
{
    /**
     * @param array $data
     * @param string|null $filename
     * @return ExcelExport
     */
    public static function export(array $data, ?string $filename=null): ExcelExport
    {
        return new ExcelExport($data, $filename ?: uniqid('file', true).'.xlsx');
    }

    /**
     * @param string $file
     * @return bool|SimpleXLSX
     */
    public static function import(string $file)
    {
        return SimpleXLSX::parse($file);
    }
}
