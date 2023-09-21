<?php

namespace App\Services;

class FileService
{
    /**
     * @param [type] $image
     * @param string $path
     * @return String
     */
    public function storeFile($image, $path = '') : String
    {
        $result = $image->store($path);
        
        return str_replace('public/', 'storage/', $result);
    }
}