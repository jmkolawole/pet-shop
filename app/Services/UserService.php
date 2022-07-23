<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'name' => $user->name,
            'email' => $user->email,
        ];
        $result = $this->securityService->createPublicToken($send);

        return $result->original;
    }

    public function createUser(Request $req)
    {

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password); // bcrypt || sha1 ||
        $user->save();

        $send = User::where('name', $req->name)->first();
        $send = [
            'id' => $send->id,
            'name' => $send->name,
            'email' => $send->email,
        ];

        $result = $this->securityService->createPublicToken($send);

        return $result->original;
    }
 
}