<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponder;
    
    /** @var AuthService $auth */
    protected $auth;
    
    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register (Request $request): JsonResponse
    {
        return $this->auth->register($request);
    }
    
    public function login (Request $request)
    {
        return $this->auth->login($request);
    }
    
    public function logout(Request $request)
    {
        return $this->auth->logout($request);
    }
    
    public function getAuthenticatedUser(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            
        } catch (\Exception $e) {
        
        }
    }
}
