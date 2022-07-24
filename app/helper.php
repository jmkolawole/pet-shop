<?php

use App\Models\User;
use Illuminate\Http\Response;

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
