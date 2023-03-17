<?php

namespace App\Repository\ProductPhotos;

use App\Models\ProductPhoto;

class ProductPhotosRepository
{

    protected ProductPhoto $model;

    public function __construct(ProductPhoto $model)
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

    public function update(ProductPhoto $productPhoto, array $productPhotoValid)
    {
        return $productPhoto->update($productPhotoValid);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}
