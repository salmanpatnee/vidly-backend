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

        return response()->json([
            'status_code'  => Response::HTTP_CREATED,
            'message'  => 'User registered successfully.',
            'access_token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        try {
            $attributes = $request->validate([
                'email'     => 'email|required',
                'password'  => 'string|required',
            ]);

            if (!Auth::attempt($attributes)) {

                return response()->json([
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Email or Password is not valid.'
                ]);
            }

            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;


            return response()->json([
                'status_code'  => Response::HTTP_OK,
                'access_token' => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'     => 'Something went wrong.',
                'error'       => $th
            ]);
        }
    }
}
