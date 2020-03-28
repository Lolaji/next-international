<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller {

    public function upload (Request $request, $folderName=null) {

            $file = $request->file('file');

            if (!is_null($folderName))
                $dir = "public/images/$folderName";
            else 
                $dir = 'public/images';

            $path = $file->store($dir);
        
            $response['filename'] = str_replace("$dir/", '', $path);

            return $response;
    }

}
