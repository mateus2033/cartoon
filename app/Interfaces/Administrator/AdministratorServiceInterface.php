<?php

namespace App\Interfaces\Administrator;

interface AdministratorServiceInterface 
{
    public function showUserAdministrator(int $data);
    public function manageSaveUserAdministrator(array $data);
    public function manageUpdateUserAdministrator(array $data);
    public function manageDeleteUserAdministrator(int $data);
}