<?php

namespace App\Interfaces\Stock;

use App\Models\Stock;

interface StockRepositoryInterface {
    public function findById(int $id);
    public function create(array $data);
    public function update(Stock $stock, array $data);
    public function destroy(int $id);
}