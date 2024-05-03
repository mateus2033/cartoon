<?php

namespace App\Services\Category;

use App\Interfaces\Category\CategoryRepositoryInterface;
use App\Interfaces\Category\CategoryServiceInterface;
use App\Utils\ConstantMessage\ConstantMessage;
use App\Utils\ErroMensage\ErroMensage;

class CategoryService implements CategoryServiceInterface {

    private CategoryRepositoryInterface $categoryRepository; 

    public function __construct(CategoryRepositoryInterface $categoryRepository)
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