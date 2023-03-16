<?php

namespace App\Interfaces\Product;

interface ProductServiceInterface {
    public function index($paginate);
    public function indexOfProductForUser($paginate);
    public function indexOfMoreSoldInMonth();
    public function getProductMoreSold();
    public function manageStorageProduct(array $product, array $stock, array $image);
    public function showProductById(int $product_id);
    public function manageUpdateProduct(array $product, array $stock);
    public function destroy(int $product_id);
}