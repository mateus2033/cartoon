<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $fillable = [
        'stock_min',
        'stock_max',
        'stock_current',
        'product_id'
    ];

    private int $stock_min;
    private int $stock_max;
    private int $stock_current;
    private int $product_id;



    /**
     * Get the value of stock_min
     */ 
    public function getStock_min(): int
    {
        return $this->stock_min;
    }

    /**
     * Set the value of stock_min
     *
     */ 
    public function setStock_min($stock_min): void
    {
        $this->stock_min = $stock_min;
    }

    /**
     * Get the value of stock_max
     */ 
    public function getStock_max(): int
    {
        return $this->stock_max;
    }

    /**
     * Set the value of stock_max
     */ 
    public function setStock_max($stock_max): void
    {
        $this->stock_max = $stock_max;
    }

    /**
     * Get the value of stock_current
     */ 
    public function getStock_current(): int
    {
        return $this->stock_current;
    }

    /**
     * Set the value of stock_current
     */ 
    public function setStock_current($stock_current): void
    {
        $this->stock_current = $stock_current;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id(): int
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     */ 
    public function setProduct_id($product_id): void
    {
        $this->product_id = $product_id;
    }
}
