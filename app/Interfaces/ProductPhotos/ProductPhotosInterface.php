<?php
namespace App\Interfaces\ProductPhotos;

use App\Models\ProductPhoto;

interface ProductPhotosInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(ProductPhoto $stock, array $data);
    public function destroy(int $id);
}
