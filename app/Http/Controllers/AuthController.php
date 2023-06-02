<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $tokenRequest = Request::create('/oauth/token', 'post', [
            'grant_type' => 'password',
            'client_id' => config('passport.password_access_client.id'),
            'client_secret' => config('passport.password_access_client.secret'),
            'username' => $request->input('email'),
            'password' => $request->input('password')
        ]);


        return app()->handle($tokenRequest);
    }

    public function register(UserRegisterRequest $request)
    {
        $payload = $request->only('name', 'email', 'password');

        try {
            User::create($payload);

            return response()->json([
                'status' => 'success',
                'message' => __('auth.user_created')
            ], Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'failed',
                'message' => __('general.general_error', ['noun' => 'user'])
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user()->with('preferences')->first());
    }
}
