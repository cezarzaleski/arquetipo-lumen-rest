<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Response;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $response = explode(':', $request->header('Authorization'));
        $token = array_key_exists(1, $response) ? trim($response[1]) : false;
        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token não localizado.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token expirado.'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Ocorreum um erro ao decodificar token.'
            ], Response::HTTP_BAD_REQUEST);
        }
//        $user = User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
//        $request->auth = $user;
        return $next($request);
    }
}
