<?php


namespace App\Application\Controllers;

use App\Components\Http\Request;
use App\Components\Image\Image;

class ImageFormHandleAndResizeTest
{
    public function test(Request $request)
    {
        $file= $request->file('file')->upload('images');


        return  Image::load($file->getUploadedFile())
            ->removeOldImage()
            ->resizeByRatio(10)
            ->save($file->getUploadedFile());
    }
}
