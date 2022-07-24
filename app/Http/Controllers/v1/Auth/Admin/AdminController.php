<?php

namespace App\Http\Controllers\v1\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\UpdateUserRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\SendsApiResponse;

class AdminController extends Controller
{
    use SendsApiResponse;
    private UserService $userService;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserService $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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

    public function userListing()
    {
        $users = $this->userRepository->userListing();
        return $this->successResponse($users);
    }

    public function userEdit(UpdateUserRequest $request)
    {
        
        $data = $request->validated();
        $uuid = $request->route('uuid');
        return $this->successResponse($this->userRepository->editUser($uuid,$data));
    }

    public function userDelete(Request $request)
    {
        $uuid = $request->route('uuid');
        return $this->successResponse($this->userRepository->deleteUser($uuid), 'User successfully deleted');
    }



}
