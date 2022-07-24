<?php
namespace App\Services;

use App\Models\JwtToken;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService {
    private SecurityService $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    public function loginUser(Request $req) {

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

    
    public function createUser(Request $request,$status)
    {

        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->uuid = Str::uuid();
        $user->email = $request->email;
        $user->is_admin = $status;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->password = bcrypt($request->password);
        $user->save();

        $send = User::where('email', $request->email)->first();
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

    
    public function logoutUser($request)
    {
        $token = $request->token;
        $jwt = JwtToken::where('unique_id',$token)->first();
        $jwt->delete();

        return;
    }
 
}