<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
// use Laravel\Sanctum\PersonalAccessToken;

class ValidateSanctumToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah ada token dalam header Authorization
        $token = $request->bearerToken();

        if (!$token) {
            // Jika tidak ada token, kembalikan pesan kesalahan
            return response()->json(['message' => 'Token not provided. Please login.'], 401);
        }

        // Cek apakah token valid dan dapatkan token modelnya
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }

        // Dapatkan pengguna terkait dengan token
        $user = $accessToken->tokenable;

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Set pengguna ke dalam request sehingga tersedia di permintaan berikutnya
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Lanjutkan permintaan
        return $next($request);
    }
}
