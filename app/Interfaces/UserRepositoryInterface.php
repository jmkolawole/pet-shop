<?php
namespace App\Interfaces;


interface UserRepositoryInterface {
    public function userListing();
    public function editUser($uuid,$data);
    public function deleteUser($uuid);
    public function userInfo($uuid);
}