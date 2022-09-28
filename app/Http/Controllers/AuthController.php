<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
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
                'token_type'   => 'Bearer'
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
