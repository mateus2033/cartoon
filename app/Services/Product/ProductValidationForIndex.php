<?php 

namespace App\Services\Product;

use App\Utils\ConstantMessage\product\ProductMessage;

class ProductValidationForIndex 
{
    /**
     * @var int $page
     */
    private int $page;

    /**
     * @var int $perpage
     */
    private int $perpage;

    /**
     * @var bool $paginate
     */
    private bool $paginate;

    /**
     * @var bool $isValid
     */
    private bool $isValid;

    /**
     * @var array $message 
     */
    public array $message;

    public function validateFormIndex(array $data) 
    {
        $this->validateProduct($data);
        if ($this->isValid == true) {
            return $this->assemblesTheValidatedData();
        }
        return $this;
    }

    private function assemblesTheValidatedData(): array 
    {
        return [
            'page' => $this->page,
            'perpage' => $this->perpage,
            'paginate' => $this->paginate
        ];
    }

    private function validateProduct(array $data)
    {
        $count = 0;
        $array = [];
        $error = [];
      
        $array['page']  = $this->_page($data);
        $array['perpage'] = $this->_perpage($data);
        $array['paginate'] = $this->_paginate($data);
        
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
     * @param array $data
     * @return string|null
     */
    private function _page(array $data)
    {   
        if(!isset($data['page']))
        {
            return ProductMessage::REQUIRED;
        }

        if (preg_match('/[^0-9]/', $data['page']))
        {
            return ProductMessage::ONLY_INTEGER;
        }

        if($data['page'] <= 0)
        {
            return ProductMessage::ONLY_POSITIVE;
        }

        $this->page = (int) $data['page'];
        return null;
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function _perpage(array $data)
    {
        if(!isset($data['perpage']))
        {
            return ProductMessage::REQUIRED;
        }

        if (preg_match('/[^0-9]/', $data['perpage']))
        {
            return ProductMessage::ONLY_INTEGER;
        }

        if($data['perpage'] <= 0)
        {
            return ProductMessage::ONLY_POSITIVE;
        }

        $this->perpage = (int) $data['perpage'];
        return null;
    }

    /**
     * @param array $paginate
     * @return string|null
     */
    private function _paginate(array $data)
    { 
        if(!isset($data['paginate']))
        {
            return ProductMessage::REQUIRED;
        }
        
        $booleanValue = filter_var($data['paginate'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    
        if(!is_bool($booleanValue))
        {
            return ProductMessage::ONLY_BOOLEAN;
        }

        $this->paginate = $booleanValue;
        return null;
    }
}