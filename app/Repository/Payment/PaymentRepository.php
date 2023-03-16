<?php

namespace App\Repository\Payment;

use App\Interfaces\Payment\PaymentRepositoryInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface {

    
    protected Payment $model;

    public function __construct(Payment $model)
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