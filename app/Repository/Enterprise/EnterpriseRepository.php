<?php 

namespace App\Repository\Enterprise;

use App\Interfaces\Enterprise\EnterpriseRepositoryInterface;
use App\Models\Enterprise;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    protected Enterprise $model;
    
    public function __construct(Enterprise $model)
    {
        $this->model = $model;
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