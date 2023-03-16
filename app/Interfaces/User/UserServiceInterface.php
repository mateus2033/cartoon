<?php

namespace App\Interfaces\User;

interface UserServiceInterface {
    public function index($data);
    public function manageStorageUser(array $data);
    public function showUserById(int $user_id);
    public function getUserById(int $user_id);
    public function manageUpdateUser(array $data);
    public function manageDestroyUser(int $user_id);
}
