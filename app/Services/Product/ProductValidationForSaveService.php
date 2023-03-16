<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Category\CategoryService;
use App\Utils\ConstantMessage\ConstantMessage;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class ProductValidationForSaveService extends Product
{

    private CategoryService $categoryService;
    private bool  $isValid;
    public  array $message;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function validFormProduct(array $data)
    {   
        $this->validateProduct($data);
        if ($this->isValid == true) {
            return $this->mountProduct();
        }
        return $this;
    }


    private function mountProduct(): array
    {
        return [
            'name'        => $this->getName(),
            'price'       => $this->getPrice(),
            'category_id' => $this->getCategory_id()
        ];
    }

    private function validateProduct(array $data)
    {
        $count = 0;
        $array = [];
        $error = [];
        $data  = collect($data);
       
        $array['name']  = $this->_name($data->get('name'));
        $array['price'] = $this->_price((float) $data->get('price'));
        $array['category_id'] = $this->_category_id((int) $data->get('category_id'));
        
        foreach ($array as $key => $value) {
            if (!is_null($value)) {
                $error[$key] = $value;
                $count++;
            }
        }

        if ($count > 0) {
            $this->isValid = false;
            $this->message = $error;
        } else {
            $this->isValid = true;
            $this->message = $array;
        }
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function _name($name)
    {
        if(!isset($name))
        {
            return ConstantMessage::REQUIRED;
        }
        
        if(!is_string($name))
        {
            return ConstantMessage::ONLY_STRING;
        }

        $this->setName($name);
        return null;
    }

    /**
     * @param float $price
     * @return string|null
     */
    private function _price($price)
    {
        if(!isset($price))
        {
            return ConstantMessage::REQUIRED;
        }

        if($price <= 0) 
        {
            return ConstantMessage::INVALID_PRICE;
        }
       
        if(!is_float($price))
        {
            return ConstantMessage::ONLY_FLOAT;
        }
        
        $this->setPrice($price);
        return null;
    }

    /**
     * @param  int $category_id
     * @return string|null
     */
    private function _category_id($category_id)
    {      
        if(!isset($category_id))
        {
            return ConstantMessage::REQUIRED;
        }

        if(!is_integer($category_id))
        {
            return ConstantMessage::ONLY_INTEGER;
        }
       
        $category = $this->categoryService->showCategoryById($category_id);
        if(is_array($category))
        {   
            return $category['error'];
        }
        
        $this->setCategory_id($category_id);
        return null;
    }
}
