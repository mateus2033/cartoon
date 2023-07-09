<?php 

namespace App\Interfaces\Bank;

use App\Models\Bank;

interface BankRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(Bank $bankData ,array $data);
    public function destroy(int $id);
    public function getBankByCodeAndName(array $data);
}