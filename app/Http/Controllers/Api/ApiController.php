<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiController extends Controller
{
    public function register(Request $request) {
        try {
            $validate = Validator::make(
                $request->all(), [
                    'name'  => 'required',
                    'email'  => 'required|email|unique:users,email',
                    'password'  => 'required|confirmed|min:8',
                ]
            );
    
            if($validate->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'validation error',
                    'error'     => $validate->errors(),
                ], 401);
            }
    
            $user = User::create([
                'name'  => $request->name,
                'email'  => $request->email,
                'password'  => $request->password,
            ]);
    
            return response()->json([
                'status'    => true,
                'message'   => 'User created Succesfully',
                'token'     => $user->createToken('API TOKEN')->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => false,
                'message'   => $th->getMessage(),
            ], 500);
        }
    }
    public function login(Request $request) {
        try {
            $validate = Validator::make(
                $request->all(), [
                    'email'  => 'required|email',
                    'password'  => 'required',
                ]
            );
    
            if($validate->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'validation error',
                    'error'     => $validate->errors(),
                ], 401);
            }
            if (!Auth::attempt(($request->only(['email','password'])))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went really wrong!',
                ],401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status'    => true,
                'message'   => 'Succesfully login',
                'token'     => $user->createToken('API TOKEN')->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => false,
                'message'   => $th->getMessage(),
            ], 500);
        }
    }
    public function profile() {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile Info',
            'data' => $user,
            'id' => auth()->user()->id,
        ], 200);
    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status'        => true,
            'message'       => 'Succesfully logout',

        ]);
    }
}
