<?php

namespace App\Services;

use App\Models\JwtToken;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Response;


class UserService
{
    private SecurityService $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    public function loginUser(Request $req)
    {

        $user = User::where('email', $req->email)->firstOrFail();

        if (!Hash::check($req->password, $user->password)) {
            return false;
        }
        $send = [
            'id' => $user->id,
            'uuid' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'is_admin' => $user->is_admin
        ];

        $result = $this->securityService->createPublicToken($send);

        return $result->original;
    }


    public function createUser(Request $request, $status)
    {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'uuid' => Str::uuid(),
            'email' => $request->email,
            'is_admin' => $status,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password)
        ]);


        $send = DB::table('users')->where('email', $request->email)->first();

        $send = [
            'id' => $send->id,
            'uuid' => $send->uuid,
            'first_name' => $send->first_name,
            'last_name' => $send->last_name,
            'email' => $send->email,
            'is_admin' => $send->is_admin
        ];


        $result = $this->securityService->createPublicToken($send);

        return $result->original;
    }

    public function logoutUser($request)
    {
        $token = $request->token;
        $jwt = JwtToken::where('unique_id', $token)->first();
        $jwt->delete();

        return;
    }

    public function checkIfUserExist($email)
    {
        $user = User::whereEmail($email)->first();
        if (!$user) {
            throw new \Exception('This account does not exist in our records', Response::HTTP_FORBIDDEN);
        }

        return $user;
    }

    public function generateResetToken($email, $token)
    {
        //First delete an existing token
        PasswordReset::whereEmail($email)->delete();

        //Give a new token

        PasswordReset::create([
            'email' => $email,
            'token' => $token
        ]);

        return true;
    }

    public function resetPassword($email,$token,$password)
    {
        $this->verifyToken($token);
        
        $user = $this->checkIfUserExist($email);

        $user->password = bcrypt($password);
        $user->save();
        
        //Delete token
        $this->deleteResetToken($token);

        return;
    }

    public function deleteResetToken($token) : void
    {
        PasswordReset::where('token', $token)->delete();
        return;
    }

    public function verifyToken($token) : void
    {
        $verified_token = PasswordReset::where('token','=', $token)->first();
        if($verified_token){
            return;
        }

        throw new \Exception(
            "Invalid token or details",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );

    }

}
