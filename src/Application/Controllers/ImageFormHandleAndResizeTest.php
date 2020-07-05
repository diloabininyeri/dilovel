<?php


namespace App\Application\Controllers;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Components\Image\Image;

class ImageFormHandleAndResizeTest
{
    public function test(Request $request)
    {

        // $request->file('images')->upload('images')->getUploadedFile();
        $files=$request->files('images');

        $uploaded=[];
        /**
         * @var File[] $files
         */
        foreach ($files as $file) {
            $uploaded[]=  $file->upload('images')->getUploadedFile();
        }
        return $uploaded;
    }
}
