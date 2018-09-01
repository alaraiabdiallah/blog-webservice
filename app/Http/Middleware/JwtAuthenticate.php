<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Components\Api;

class JwtAuthenticate
{

    use Api;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('auth-token');

        if (!$token) {
            return $this->apiResponse('Token not provided.', 401);
        }
        
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $user = User::find($credentials->sub);
            $request->auth = $user;
        } catch (ExpiredException $e) {
            return $this->apiResponse('Provided token is expired.', 400);
        } catch (Exception $e) {
            return $this->apiResponse('An error while decoding token.', 400);
        }
        return $next($request);
    }
}
