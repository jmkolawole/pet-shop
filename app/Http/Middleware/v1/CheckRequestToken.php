<?php

namespace App\Http\Middleware\v1;



use App\Services\SecurityService;
use Closure;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Illuminate\Http\Response;


class CheckRequestToken
{
    private SecurityService $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $this->checkForToken($request);
        $request->request->add(['token' => $token]);

    
        if(!$this->securityService->checkToken($request)) {
            return response()->json(['error' => 'Token expired'], 401);
        } 

        return $next($request);
    }

    private function checkForToken($request){
        $token_string = $request->header('Authorization');
        if(empty($token_string)){
            throw new \Exception('Authorization token is required', Response::HTTP_EXPECTATION_FAILED);
        }

        $jwtToken = explode(' ',$token_string)[1];
        return $jwtToken;
    }
}
