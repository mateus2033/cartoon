<?php

namespace App\Interfaces\Acquisitions;

interface AcquisitionsRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}