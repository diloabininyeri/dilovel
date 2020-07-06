<?php


namespace App\Components\File;

class Excel
{
    public static function export(array $data, ?string $filename=null): ExcelExport
    {
        return new ExcelExport($data, $filename ?: uniqid('file', true).'.xlsx');
    }
}
