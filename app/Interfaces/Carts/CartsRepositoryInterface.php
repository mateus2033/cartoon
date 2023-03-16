<?php

namespace App\Interfaces\Carts;

interface CartsRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}