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
        $domain = request()->getSchemeAndHttpHost();
        $result = $image->store($path);
        
        return $domain . '/' . str_replace('public/', 'storage/', $result);
    }
}