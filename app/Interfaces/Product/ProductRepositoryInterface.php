<?php

namespace App\Interfaces\Product;

use App\Models\Product;

interface ProductRepositoryInterface {
    public function getAll(int $page, int $perpage, bool $paginate);
    public function findById(int $id);
    public function create(array $data);
    public function update(Product $product, array $data);
    public function destroy(int $id);
    public function getProductMoreSold(int $page, int $perpage, bool $paginate, string  $dateInitial, string $dateNow);
}