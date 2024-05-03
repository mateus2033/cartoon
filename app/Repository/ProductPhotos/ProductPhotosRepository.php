<?php

namespace App\Repository\ProductPhotos;

use App\Models\ProductPhoto;
use App\Interfaces\ProductPhotos\ProductPhotosRepositoryInterface;
use App\Repository\BaseRepository\BaseRepository;

class ProductPhotosRepository extends BaseRepository implements ProductPhotosRepositoryInterface
{
    protected $modelClass = ProductPhoto::class;
}
