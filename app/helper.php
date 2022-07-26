<?php

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

function probeForRole($email, $role)
{
    $user = User::whereEmail($email)->first();
    
    if($user){
        switch ($role) {
            case 'user':
                if($user->is_admin === 0){
                    return;
                }
                else{
                    throw new \Exception('You are not allowed login via this endpoint', Response::HTTP_FORBIDDEN);         
                }
                break;
    
            case 'admin':
                if($user->is_admin === 1){
                    return;
                }
                else{
                    throw new \Exception('You are not allowed login via this endpoint', Response::HTTP_FORBIDDEN);
                }
                break;
    
            default:
                # code...
                break;
        }
    }else{
        //The security service will handle that
        return;
    }

    
}


function getRandomString()  : string
{
    $token = Str::random(60);
    return $token;
}

function sendEmail($email,$token)
{

}
