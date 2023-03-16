<?php

namespace App\Services\Category;

use App\Interfaces\Category\CategoryServiceInterface;
use App\Repository\Category\CategoryRepository;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class CategoryService implements CategoryServiceInterface {

    private CategoryRepository $categoryRepository; 

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function showCategoryById(int $category_id)
    {      
        $category = $this->categoryRepository->findById($category_id);
        if(!is_null($category)) {
            return $category;
        }
        return ErroMensage::errorMessage(ConstantMessage::CATEGORY_NOT_FOUND);
    }
}