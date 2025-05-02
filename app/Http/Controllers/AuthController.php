<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use UploadFile;
    //
    public function register(RegisterRequest $request){

        $data = $request->validated();
        //save a photo
        if($request->hasFile('photo')){
            $data['photo'] = $this->uploadFile($request->file('photo'), 'uploads/users');
        }
        //hash password
        $data['password'] = bcrypt($data['password']);

        $user=User::create($data);
        //create token
        $token=$user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data'=>$user,
            'message'=>'User registered successfully',
            'token'=>$token,
        ],201);
    }

    public function login(LoginRequest $request){

        $data=$request->validated();
        $user = User::where('email', $data['email'])->firstOrFail();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid credentials',
            ],401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data'=>$user,
            'messages'=>'login successfully',
            'status'=>200,
            'token'=>$token,
        ],200);
    }

    public function myprofile()
    {
        $user = auth()->user()->load('posts');

        return new UserResource($user);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        //logout from all devices delete all tokens for this user
        // $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ],200);
    }
}
