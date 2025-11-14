<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthApiController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string'
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'role'=>0
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user'=>new UserResource($user),
            'token'=>$token
        ]);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
    
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error'=>'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'Could not create token'], 500);
        }
    
        return response()->json([
            'user' => new UserResource(JWTAuth::user()),
            'token' => $token
        ]);
    }    

    public function me() {
        return new UserResource(JWTAuth::user());
    }

    public function logout() {
        try {
            JWTAuth::parseToken()->invalidate();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, token invalid'], 500);
        }
    }
}
