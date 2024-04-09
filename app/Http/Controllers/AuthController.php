<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(StoreUserRequest $request){

        try {
            DB::beginTransaction();
                $user = $request->validated();
                $user = User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                ]);

                // Assign a role to the user
                $role = Role::where('name', 'user')->first();
                $user->roles()->attach($role);

            DB::commit();
                $token = $user->createToken('authToken')->plainTextToken;
                return $this->apiResponse(new UserResource($user),$token,'registered successfully',200);
        
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    public function login(LoginRequest $request){
        try {
                if (!\Auth::attempt($request->only('email', 'password'))) {
                    return response()->json([
                        'message' => 'Invalid login details'
                    ], 401);
                }
                $user = User::where('email', $request['email'])->firstOrFail();
                $token = $user->createToken('authToken')->plainTextToken;
                return $this->apiResponse(new UserResource($user),$token,'login  successfully',200);
                
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
