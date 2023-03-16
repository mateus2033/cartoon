<?php

namespace App\Interfaces\BankData;

interface BankDataRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}