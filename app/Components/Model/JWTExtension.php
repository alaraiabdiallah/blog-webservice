<?php

namespace App\Components\Model;

use Firebase\JWT\JWT;
trait JWTExtension
{
    public function JWTEncode()
    {
        $payload = [
            'iss' => env('JWT_ISSUER','lumen-jwt'), // Issuer of the token
            'sub' => $this->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + env('JWT_EXPIRE_TIME',3600) // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET','some-secret'));
    }
}