<?php 

namespace App\Interfaces\Enterprise;

use App\Models\Enterprise;

interface EnterpriseRepositoryInterface 
{
    public function findById(int $id);
    public function create(array $data);
    public function update(Enterprise $enterprise, array $data);
    public function destroy(int $id);
}
