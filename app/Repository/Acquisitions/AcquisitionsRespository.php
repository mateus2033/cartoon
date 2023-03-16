<?php

namespace App\Repository\Acquisitions;

use App\Interfaces\Acquisitions\AcquisitionsRepositoryInterface;
use App\Models\Acquisitions;

class AcquisitionsRespository implements AcquisitionsRepositoryInterface{

    protected Acquisitions $model;

    public function __construct(Acquisitions $model)
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
