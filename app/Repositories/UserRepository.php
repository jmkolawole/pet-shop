<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    
    public function userListing()
    {
        $users = User::where('is_admin',0)->get();
        return $users;
    }


    public function editUser($uuid, $data)
    {
        $user = User::where('uuid',$uuid)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function deleteUser($uuid)
    {
        $user = User::where('uuid',$uuid)->first();
        $user->delete();
        
        return;
    }
}