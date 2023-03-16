<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'price',
        'category_id'
    ];

    private int $id;
    private string $name;
    private string $type;
    private int    $amount;
    private float  $price;
    private string $category_id;


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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     */ 
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     */ 
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * Get the value of category_id
     */ 
    public function getCategory_id(): int
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     */ 
    public function setCategory_id($category_id): void
    {
        $this->category_id = $category_id;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id', 'id');
    }

    public function acquisitions()
    {
        return $this->belongsTo(Acquisitions::class,'id', 'product_id');
    }

    public function phots()
    {
        return $this->hasMany(ProductPhoto::class, 'product_id');
    }
}
