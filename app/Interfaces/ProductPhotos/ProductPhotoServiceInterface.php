<?php

namespace App\Interfaces\ProductPhotos;

interface ProductPhotoServiceInterface 
{
    public function manageStorageProductPhotos(array $images,  $product);
}