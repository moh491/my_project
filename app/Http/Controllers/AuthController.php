<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login (LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        if (!Auth::guard($data['user_type'])->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return $this->error(['message' => 'invalid credentials']);
        }
        $user = Auth::guard($data['user_type'])->user();
        $token = $user->createToken('auth_' . $data['user_type'] . '_token', ['*'])->plainTextToken;
        return $this->success('login successful', $user, $token);
    }


    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $user=$request->user();
        $user->tokens()->delete();
        return response()->json([
            'status'=>'1',
            'data'=>[], 'message'=>'user logout successfully'
        ]);
    }


}
