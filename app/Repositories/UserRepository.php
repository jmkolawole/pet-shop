<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\JwtToken;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function userListing()
    {
        $users = User::where('is_admin', 0)->get();
        return $users;
    }

    public function userInfo($uuid)
    {
        return $this->findUserByUuid($uuid);
    }




    public function editUser($uuid, $data)
    {
        $user = User::where('uuid', $uuid)->update([
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
        $user = $this->findUserByUuid($uuid);
        //Delete user remnant token in jwt table
        $this->deleteToken($uuid);

        $user->delete();


        return;
    }

    public function deleteToken($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        JwtToken::whereUserId($user->id)->delete();
        return;
    }



    public function findUserByUuid($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        return $user;
    }
}
