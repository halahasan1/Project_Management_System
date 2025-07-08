<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected AuthService $service;

    /**
     * Summary of __construct
     * @param \App\Services\AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }


    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->service->login($request->email, $request->password);
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], Response::HTTP_OK);
    }

    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], Response::HTTP_OK);
    }


}
