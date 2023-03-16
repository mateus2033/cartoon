<?php

namespace App\Interfaces\Payment;

interface PaymentRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}