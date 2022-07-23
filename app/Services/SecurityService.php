<?php

namespace App\Services;

use DateTimeImmutable;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Signer\Rsa\Sha512;

class SecurityService
{

    public function checkToken(Request $request)
    {
        
        $config = $this->privateKey();
        $token = $request->token;
        $token = $config->parser()->parse($token);
        assert($token instanceof UnencryptedToken);
        $now = new DateTimeImmutable();

        if ($token->claims()->get('exp') > $now) {
            $request['info'] = $this->extract_info($request);
            return true;
        }

        return false;
    }


    public function privateKey()
    {
        
        $public = config('JWT')['public_key'];
        $private = config('JWT')['private_key'];
    
        $config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file($private),
            InMemory::file($public)
        );

        return $config;
    }


    public function createPublicToken($user)
    {
        $config = $this->privateKey();
        $now = new DateTimeImmutable();
        $token = $config->builder()
            ->issuedAt($now)
            ->expiresAt($now->modify('1 hour'))
            ->withClaim('user_id', $user["id"])
            ->withClaim('user_uuid', $user["uuid"])
            ->withClaim('first_name', $user["first_name"])
            ->withClaim('last_name', $user["last_name"])
            ->withClaim('email', $user["email"])
            ->withClaim('is_admin', $user["is_admin"])
            ->getToken($config->signer(), $config->signingKey());
        $token = $token->toString();
        return response()->json(['token' => $token]);
    }

    
    public function extract_info($token)
    {
        $config = $this->privateKey();
        $token = $config->parser()->parse($token->token);
        assert($token instanceof UnencryptedToken);
        $user = [
            'id' => $token->claims()->get('user_id'),
            'uuid' => $token->claims()->get('user_uuid'),
            'first_name' => $token->claims()->get('first_name'),
            'last_name' => $token->claims()->get('last_name'),
            'email' => $token->claims()->get('email'),
            'is_admin' => $token->claims()->get('is_admin')
        ];
        return $user;
    }
}
