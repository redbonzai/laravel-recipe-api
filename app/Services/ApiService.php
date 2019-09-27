<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Laravel\Passport\Passport;


class ApiService
{
    use ApiResponder;

    public function __construct()
    {
        //
    }
}
