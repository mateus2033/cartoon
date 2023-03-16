<?php

namespace App\Repository\Product;

use App\Interfaces\Product\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface {

    
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Product $product, array $productValid)
    {
        return $product->update($productValid);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}