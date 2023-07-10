<?php

namespace App\Repository\BankData;

use App\Interfaces\BankData\BankDataRepositoryInterface;
use App\Models\BankData;

class BankDataRepository implements BankDataRepositoryInterface
{
    private int $user;
    protected BankData $model;   

    public function __construct(BankData $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {   
        return $this->model->all()->where('user_id','=', auth('api')->user()->id);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(BankData $bankData, array $data)
    {
        return $bankData->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}
