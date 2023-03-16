<?php

namespace App\Repository\Category;

use App\Interfaces\Category\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {

    
    protected Category $model;
    

    public function __construct(Category $model)
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

    public function update(array $data)
    {
        return $this->model->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }

}