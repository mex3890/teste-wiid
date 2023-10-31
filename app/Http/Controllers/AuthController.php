<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiBaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return $this->sendResponse(
                'Login successfully.',
                ['token' => Auth::user()->createToken('token')->plainTextToken],
                status_code: Response::HTTP_CREATED
            );
        }

        return $this->sendErrorResponse('Unauthorized.', status_code: Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $authenticatedUser = Auth::user();

        if ($request->get('revoke_all') === 'true') {
            if ($authenticatedUser->tokens()->delete()) {
                return $this->sendResponse('Success on revoke current User all tokens.');
            }

            return $this->sendErrorResponse(
                'Failed on revoke current User all tokens.',
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        if ($authenticatedUser->currentAccessToken()->delete()) {
            return $this->sendResponse('Success on revoke current User token.');
        }

        return $this->sendErrorResponse(
            'Failed on revoke current User token.',
            status_code: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public function me(): JsonResponse
    {
        if (($user = Auth::user()) instanceof User) {
            return $this->sendResponse('Success on retrieve User.', $user);
        }

        return $this->sendErrorResponse('Failed on retrieve User.');
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->validated('name'),
            'last_name' => $request->validated('last_name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);

        if ($user instanceof User) {
            return $this->sendResponse('User created.', status_code: Response::HTTP_CREATED);
        }

        return $this->sendErrorResponse(
            'Failed on create User.',
            status_code: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
