<?php

namespace App\Http\Controllers\v1\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\SendsApiResponse;

class AdminController extends Controller
{
    use SendsApiResponse;
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'=> 'string|required',
            'password'=> 'string|required',
        ]);

        //Make Sure only admin tries to register here
        probeForRole($request->email,'admin');
        $user = $this->userService->loginUser($request);
        
        return $this->successResponse($user);
    }

    public function createAdmin(Request $request)
    {
        $user = $this->userService->createUser($request, 1);
    
        return $this->successResponse($user);
    }

    public function adminLogout(Request $request)
    {
       $this->userService->logoutUser($request);
       return $this->successResponse([],'Successfully logged out');
    }

}
