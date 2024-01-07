<?php

namespace App\Interfaces\Product;

interface ProductServiceInterface {
    public function index(array $data);
    public function indexOfProductForUser(array $data);
    public function indexOfMoreSoldInMonth(array $data);
    public function getProductMoreSold(array $data);
    public function manageStorageProduct(array $product, array $stock, array $image);
    public function showProductById(int $product_id);
    public function manageUpdateProduct(array $product, array $stock);
    public function destroy(int $product_id);
}