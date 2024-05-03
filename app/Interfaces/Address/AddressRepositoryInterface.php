<?php

namespace App\Interfaces\Address;

use App\Models\Address;

interface AddressRepositoryInterface {
    public function getAll(int $page, int $perpage, bool $paginate);
    public function findById(int $id);
    public function create(array $data);
    public function update(Address $address, array $data);
    public function destroy(int $id);
    public function findByRelations(int $data);
}