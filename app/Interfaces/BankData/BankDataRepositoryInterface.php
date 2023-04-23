<?php

namespace App\Interfaces\BankData;

use App\Models\BankData;

interface BankDataRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(BankData $bankData ,array $data);
    public function destroy(int $id);
}