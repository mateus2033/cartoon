<?php

namespace App\Interfaces\Category; 

interface CategoryRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}