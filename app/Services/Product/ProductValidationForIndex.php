<?php 

namespace App\Services\Product;

use App\Utils\ConstantMessage\product\ProductMessage;

class ProductValidationForIndex 
{
    private bool  $isValid;
    public  array $message;

    public function validateFormIndex(array $data) 
    {
        $this->validateProduct($data);
        if ($this->isValid == true) {
            return $data;
        }
        return $this;
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

        if(!is_integer($data['page']))
        {
            return ProductMessage::ONLY_INTEGER;
        }

        if($data['page'] <= 0)
        {
            return ProductMessage::ONLY_POSITIVE;
        }

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

        if(!is_integer($data['perpage']))
        {
            return ProductMessage::ONLY_INTEGER;
        }

        if($data['perpage'] <= 0)
        {
            return ProductMessage::ONLY_POSITIVE;
        }

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

        if(!is_bool($data['paginate']))
        {
            return ProductMessage::ONLY_BOOLEAN;
        }

        return null;
    }
}