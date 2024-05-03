<?php

namespace App\Interfaces\Category; 

interface CategoryRepositoryInterface {
    public function findById(int $id);
}