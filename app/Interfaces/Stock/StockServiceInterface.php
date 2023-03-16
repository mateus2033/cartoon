<?php

namespace App\Interfaces\Stock;

use App\Models\Product;

interface StockServiceInterface {
    public function manageStorageStock(array $stock, int $product_id);
    public function manageUpdateStock(Product $product, array $stock);
    public function destroyStockRelation($stock);
}
