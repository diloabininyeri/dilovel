<?php


namespace App\Application\Controllers;

use App\Components\Http\File;
use App\Components\Http\Request;
use App\Components\Image\Image;

class ImageFormHandleAndResizeTest
{
    public function test(Request $request)
    {
        /**
         *
         */
        return $request->hasFiles('images');
    }
}
