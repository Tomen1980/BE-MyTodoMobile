<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function registrasi(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User created successfully'
            ],202);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User not created'
            ],500);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]); 
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong password'
                ], 401);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }

    public function cek(Request $request){
        return response()->json($request->user());
    }
}
