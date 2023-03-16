<?php

namespace App\Repository\Stock;

use App\Interfaces\Stock\StockRepositoryInterface;
use App\Models\Stock;

class StockRepository implements StockRepositoryInterface {

    
    protected Stock $model;

    public function __construct(Stock $model)
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

    public function update(Stock $stock, array $stockValid)
    {
        return $stock->update($stockValid);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}