<?php

namespace App\Interfaces\Administrator;

interface AdministratorServiceInterface 
{
    public function showUserAdministrator();
    public function manageSaveUserAdministrator(array $data);
    public function manageUpdateUserAdministrator(array $data);
    public function manageDeleteUserAdministrator(int $data);
}