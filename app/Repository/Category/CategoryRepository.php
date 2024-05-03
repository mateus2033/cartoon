<?php

namespace App\Repository\Category;

use App\Interfaces\Category\CategoryRepositoryInterface;
use App\Models\Category;
use App\Repository\BaseRepository\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {

    protected $modelClass = Category::class;

}