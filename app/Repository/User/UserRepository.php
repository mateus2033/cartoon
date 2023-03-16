<?php

namespace App\Repository\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {

    
    protected User $model;

    public function __construct(User $model)
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

    public function update(User $user, array $data)
    {   
        return $user->update($data);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}