<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\AuthInterface;
use App\Http\Controllers\Controller;
use App\Interfaces\UserAuthInterface;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;

class AuthController extends Controller implements UserAuthInterface
{
    private AuthInterface $authRepository;

    public function __construct(
        AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();

        if (!$this->authRepository->cekLogin($data)) {
            return response()->json(['error_message' => 'Incorrect Details. Please try again'],Response::HTTP_BAD_REQUEST);
        }
        $token = auth()->user()->createToken('NewsManagement', [(auth()->user()->is_admin ? 'admin': 'member')])->accessToken;

        return response()->json(['token' => $token]);
    }

    public function registerAdmin(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['is_admin'] = true;
        $user = $this->authRepository->register($validatedData);
        return response()->json([
            'message' => 'success insert new data user',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    public function registerMember(UserRegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['is_admin'] = false;
        $user = $this->authRepository->register($validatedData);
        return response()->json([
            'message' => 'success insert new data user',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response, 200);
    }
}
