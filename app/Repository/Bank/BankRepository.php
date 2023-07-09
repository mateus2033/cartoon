<?php

namespace App\Repository\Bank;

use App\Models\Bank;
use App\Interfaces\Bank\BankRepositoryInterface;

class BankRepository implements BankRepositoryInterface {

    protected Bank $model;

    public function __construct(Bank $model)
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

    public function update(Bank $bank, array $data)
    {
        return $bank->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getBankByCodeAndName(array $bank)
    {     
        $query = $this->model
        ->where('code', '=', $bank['code'])
        ->where('name', '=', $bank['name']);
        return $query->first();
    }
}