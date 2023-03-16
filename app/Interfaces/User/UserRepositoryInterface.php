<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(User $user,array $data);
    public function destroy(int $id);
}