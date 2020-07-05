<?php


namespace App\Application\Controllers;

use App\Components\Http\File;
use App\Components\Http\Request;

/**
 * Class ImageFormHandleAndResizeTest
 * @package App\Application\Controllers
 */
class ImageFormHandleAndResizeTest
{
    public function test(Request $request)
    {
        return $request->whenReturnCallback(
            $request->hasFiles('images'),
            fn (Request $request) => (new self())->uploadImages($request->files('images'))
        );
    }
    /**
     * @param File[] $files
     * @return array
     */
    public function uploadImages(array $files): array
    {
        $uploaded = [];
        foreach ($files as $file) {
            if ($file->getExtension()==='png') {
                $uploaded[] = $file->upload('images')->getUploadedFile();
            }
        }
        return $uploaded;
    }
}
