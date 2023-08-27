<?php

namespace Tests\Builders\Product;

use App\Models\Product;

class ProductBuilder
{
    protected $attributes = [];

    public function setId($id = null): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function name($name = null): self
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    public function price($price = null): self
    {
        $this->attributes['price'] = $price;
        return $this;
    }

    public function category_id($category_id = null): self
    {
        $this->attributes['category_id'] = $category_id;
        return $this;
    }

    public function create($quantity = null)
    {
        return Product::factory($quantity)->create($this->attributes);
    }

    public function make($quantity = null)
    {
        return Product::factory($quantity)->make($this->attributes);
    }
}
