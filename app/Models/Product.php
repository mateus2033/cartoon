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


    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getCategory_id(): int
    {
        return $this->category_id;
    }

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
