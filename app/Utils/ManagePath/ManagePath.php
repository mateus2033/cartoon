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
        $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $image->extension();
        $image->move(public_path($path), $imageName);
        return $imageName;
    }

}
