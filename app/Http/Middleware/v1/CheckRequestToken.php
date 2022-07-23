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

        
        if (!$this->securityService->checkToken($request)) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        $this->checkAdminAccess($request);

        return $next($request);
    }

    /**
     * Checks if only admin can access these route
     *
     * @param  \Illuminate\Http\Request  $request
     * @return 
     */
    private function checkAdminAccess($request)
    {
        $routeName = $request->route()->getName();
        $status = $request['info']['is_admin'];

        if ($routeName === 'admin.' && $status === 0) {
            throw new \Exception('You are not allowed to access this resource', Response::HTTP_FORBIDDEN);
        }

        return;
    }


    /**
     * Check if authorization header was supplied. Return token if supplied
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string 
     */
    private function checkForToken($request) : String
    {
        $token_string = $request->header('Authorization');
        if (empty($token_string)) {
            throw new \Exception('Authorization token is required', Response::HTTP_EXPECTATION_FAILED);
        }

        $jwtToken = explode(' ', $token_string)[1];
        return $jwtToken;
    }
}
