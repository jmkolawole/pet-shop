<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class LoginController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'email'=> 'string|required',
            'password'=> 'string|required',
        ]);
        $user = $this->userService->loginUser($request);
        return response()->json([$user]);
    }
}
