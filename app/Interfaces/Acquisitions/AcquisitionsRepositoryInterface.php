<?php

namespace App\Interfaces\Acquisitions;

interface AcquisitionsRepositoryInterface {
    public function getAll(int $page, int $perpage, bool $paginate);
    public function findById(int $id);
    public function create(array $data);
    public function destroy(int $id);
}