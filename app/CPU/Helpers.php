<?php

namespace App\CPU;

use App\Models\User;
use App\Notifications\pushNotification;
use Illuminate\Support\Facades\File;

class Helpers
{
    public static function upload_files($file){
        $extension=$file->extension();
        $name=time() .str_replace([" ","-"],"_",$file->getClientOriginalName()) ;
        $file->move(public_path("files/"),$name);
        return "files/$name";

    }
    public static function delete_file($path){

        
        File::delete(public_path("$path"));


        return ;

    }
}
