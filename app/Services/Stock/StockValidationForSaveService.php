<?php

namespace App\Services\Stock;

use App\Models\Stock;
use App\Services\Product\ProductService;
use App\Utils\ConstantMessage\ConstantMessage;

class StockValidationForSaveService extends Stock
{
    private int $stock_min = 0;
    private int $stock_max = 0;
    private int $stock_current = 0;
    private bool  $isValid;
    public  array $message;

    public function validFormStock(array $stock, int $product_id)
    {
        $this->validateStock($stock, $product_id);
        if ($this->isValid == true) {
            return $this->mountStock();
        }
        return $this;
    }

    private function mountStock(): array
    {
        return [
            'stock_min' => $this->getStock_min(),
            'stock_max' => $this->getStock_max(),
            'stock_current' => $this->getStock_current(),
            'product_id'    => $this->getProduct_id()
        ];
    }

    private function validateStock(array $data, int $product_id)
    {
        $count = 0;
        $array = [];
        $error = [];
        $data  = collect($data);
        
        $array['stock_min']     = $this->_stock_min((int) $data->get('stock_min'));
        $array['stock_max']     = $this->_stock_max((int) $data->get('stock_max'));
        $array['stock_current'] = $this->_stock_current((int) $data->get('stock_current'));
        $array['product']       = $this->_product($product_id);
        $array['validValues']   = $this->_validStockValues($data);
        
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
     * @param int $stock_min
     * @return string|null
     */
    private function _stock_min(int $stock_min)
    {
        if($stock_min <=0)
        {
            return ConstantMessage::INVALID_VALUE;
        }

        $this->stock_min = $stock_min;
        $this->setStock_min($stock_min);
        return null;
    }

    /**
     * @param int $stock_max
     * @return string|null
     */
    private function _stock_max(int $stock_max)
    {   
        if($stock_max <=0)
        {
            return ConstantMessage::INVALID_VALUE;
        }

        $this->stock_max = $stock_max;
        $this->setStock_max($stock_max);
        return null;
    }

    /**
     * @param int $stock_current
     * @return string|null
     */
    private function _stock_current(int $stock_current)
    {
        if($stock_current <=0)
        {
            return ConstantMessage::INVALID_VALUE;
        }

        $this->stock_current = $stock_current;
        $this->setStock_current($stock_current);
        return null;
    }

    /**
     * @param int $product_id
     * @return string|null
     */
    private function _product(int $product_id)
    {
        $this->setProduct_id($product_id);
        return null;        
    }

    /**
     * @return string|null
     */
    private function _validStockValues()
    {
        if($this->stock_min == 0 && $this->stock_max == 0 && $this->stock_current == 0)
        {
            return null;
        }

        if($this->stock_min > $this->stock_max || $this->stock_min > $this->stock_current)
        {
            return ConstantMessage::INVALID_STOCK_MIN;
        }

        if($this->stock_current > $this->stock_max) 
        {
            return ConstantMessage::INVALID_STOCK_CURRENT;
        }

        return null;
    }
}