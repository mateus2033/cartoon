<?php

namespace App\Repository\BankData;

use App\Interfaces\BankData\BankDataRepositoryInterface;
use App\Models\BankData;

class BankDataRepository implements BankDataRepositoryInterface
{

    protected BankData $model;

    public function __construct(BankData $model)
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

    public function update(BankData $user, array $data)
    {
        return $user->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}
