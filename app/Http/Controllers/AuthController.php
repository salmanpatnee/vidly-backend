<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attributes = request()->validate([
            'name'      => 'required|string|min:3|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|min:6|max:255',
        ]);

        $user = User::create($attributes);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(
            ['message'  => 'User registered successfully.', 'access_token' => $token,],
            Response::HTTP_CREATED
        );
    }

    public function login(Request $request)
    {
        try {
            $attributes = $request->validate([
                'email'     => 'email|required',
                'password'  => 'string|required',
            ]);

            if (!Auth::attempt($attributes)) {

                return response()->json(
                    ['message' => 'Email or Password is not valid.'],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;


            return response()->json(
                ['access_token' => $token],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'     => 'Something went wrong.',
                'error'       => $th
            ]);
        }
    }
}
