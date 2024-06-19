<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ValidateSanctumToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // // Ambil token dari header Authorization
        // $token = $request->bearerToken();

        // if (!$token) {
        //     return response()->json(['message' => 'Token not provided'], 401);
        // }

        // // Cek apakah token valid
        // $accessToken = PersonalAccessToken::findToken($token);

        // if (!$accessToken) {
        //     return response()->json(['message' => 'Invalid token'], 401);
        // }

        // // Jika token valid, lanjutkan permintaan
        // return $next($request);

         // Periksa apakah ada token dalam header Authorization
         $token = $request->bearerToken();

         if (!$token) {
             // Jika tidak ada token, kembalikan pesan kesalahan
             return response()->json(['message' => 'Token not provided. Please login.'], 401);
         }
 
         // Cek apakah token valid
         if (!Auth::guard('sanctum')->check()) {
             return response()->json(['message' => 'Invalid token or user not authenticated.'], 401);
         }
 
         // Jika token valid, lanjutkan permintaan
         return $next($request);
    }
}
