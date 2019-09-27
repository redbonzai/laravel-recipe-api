<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Exceptions\MissingScopeException;
use Laravel\Passport\Passport;
use Psy\Util\Json;


class AuthService
{
    use ApiResponder;
    
    public function __construct()
    {
        //
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register (Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            if ($validator->fails())
            {
                return $this->errorResponse($validator->errors()->all(), 422);
            }
    
            $request['password'] = Hash::make($request['password']);
            $user = new UserResource(
                User::create($request->toArray())
            );
    
            $token = $user->createToken($user->email)->accessToken;
            
        } catch(\Exception $e) {
            return $this->errorResponse('registration error for: ' .$user->email, 422);
        }
        
        return $this->respondWithToken($token, $user);
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        
        try {
            if (!Auth::attempt($credentials)) {
                return $this->errorResponse('Unauthorized', 401);
            }
            
            $user = new UserResource(
                User::where('email', $request->email)->first()
            );
            
            $token = $user->createToken($user->email)->accessToken;
            
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
        
        return $this->respondWithToken($token, $user);
    }
    
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('api')->user()->token()->revoke();
        return $this->successResponse('user authentication revoked');
    }
    
    /**
     * @param $token
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'user' => $user,
            'access_token' => $token
        ]);
    }
    
}
