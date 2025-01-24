<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function saveImage($file, $_path = 'public', $_folder = 'extra')
    {
        if (!$file) {
            return null;
        }
        // Get the extention of files
        $length = 12;
        $name = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        $filename =  $_folder . '/' . $name . '.' . $file->getClientOriginalExtension();
        // File Path Format : $_path.'/'.student-number.'/'.$_folder
        $_path = $_path;
        Storage::disk($_path)->put($filename, fopen($file, 'r+'));
        return URL::to('/') . '/storage/'  . $filename;
    }
}
