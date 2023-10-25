<?php 

namespace App\Interfaces\Enterprise;

interface EnterpriseServiceInterface 
{
    public function show(int $enterprise_id);
    public function manageStorageEnterprise(array $enterprise, array $address);
    public function manageUpdateEnterprise(array $enterprise);
    public function manageDestroyEnterprise(int $enterprise_id);
}