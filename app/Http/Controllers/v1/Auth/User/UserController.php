<?php

namespace App\Http\Controllers\v1\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\SendsApiResponse;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;

class UserController extends Controller
{
    use SendsApiResponse;
    private UserService $userService;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserService $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'string|required',
            'password' => 'string|required',
        ]);

        //Make Sure only admin tries to register here
        probeForRole($request->email, 'user');
        $user = $this->userService->loginUser($request);

        return $this->successResponse($user);
    }

    public function createUser(Request $request)
    {
        $user = $this->userService->createUser($request, 0);

        return $this->successResponse($user);
    }


    public function userInfo(Request $request)
    {
        $uuid = $request['info']['uuid'];
        $user = $this->userRepository->userInfo($uuid);
        dd($user);
        return $this->successResponse($user, 'user details fetched successfully');
    }


    public function userLogout(Request $request)
    {
        $this->userService->logoutUser($request);
        return $this->successResponse([], 'Successfully logged out');
    }

    public function userDelete(Request $request)
    {
        $uuid = $request['info']['uuid'];
        $user = $this->userRepository->deleteUser($uuid);
        return $this->successResponse([], 'Successfully Deleted');
    }

    public function forgotPassword(Request $request)
    {
        $token = getRandomString();
        $email = $request->email;

        //Check if User exists
        $this->userService->checkIfUserExist($email);

        //Generate token
        $this->userService->generateResetToken($email, $token);

        //sendEmail($email, $token);
        $message = "A reset link has been sent to your email";

        return $this->successResponse($token, $message);
    }



    public function resetPassword(Request $request)
    {
        $token = $request->token;
        $password = $request->password;
        $email = $request->email;

        $this->userService->resetPassword($email, $token, $password);

        $message = "Password reset successful";

        return $this->successResponse([], $message);
    }
}
