<?php

namespace App\Utils\ManagePath;

class ManagePath {

    /**
     * Create the file in a directory and return its name
     * @param string $path
     * @param $file
     * @return string
     */
    public static function createPath(string $path, $image): string
    {  
        $string = sprintf('%08X', mt_rand(0, 0xFFFFFFFF));
        $imageName = md5($image->getClientOriginalName() . strtotime("now")) . strtolower($string) . "." . $image->extension();
        $image->move(public_path($path), $imageName);
        return $imageName;
    }
}
