<?php 

namespace App\Interfaces\Enterprise;

interface EnterpriseRepositoryInterface 
{
    public function findById(int $id);
    public function create(array $data);
    public function update(array $data);
    public function destroy(int $id);
}
