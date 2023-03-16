<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'image',
        'product_id'
    ];

    private int $id;
    private string $image;
    private int $product_id;

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */ 
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of image
     */ 
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */ 
    public function setImage($image): void
    {
        $this->image = $image;
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
