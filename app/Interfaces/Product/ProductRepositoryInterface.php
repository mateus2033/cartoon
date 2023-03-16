<?php

namespace App\Interfaces\Product;

use App\Models\Product;

interface ProductRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(Product $product, array $data);
    public function destroy(int $id);
}