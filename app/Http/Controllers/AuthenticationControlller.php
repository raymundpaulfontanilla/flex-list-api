<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticationControlller extends Controller
{
    public function register(AuthenticationRequest $request)
    {
        $validated = $request->validated();

        $temporarySalt = Str::random(32);
        $userPassword = ($validated['password']);

        $passwordWithSalt = $userPassword . $temporarySalt;
        $passwordHash = hash('sha256', $passwordWithSalt);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => $passwordHash,
            'salt' => $temporarySalt
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'Successfully registered account, you may now try to login.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'salt' => $user->salt,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ], 201);
    }

    function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'USERNAME_OR_PASSWORD_INCORRECT',
                'message' => 'username or password is incorrect',
                'user' => null
            ], 404);
        }

        $salt = $user->salt;
        $storedHash = $user->password;

        $passwordWithSalt = $request->password . $salt;
        $hashedInput = hash('sha256', $passwordWithSalt);

        if ($hashedInput == $storedHash) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Successfully logged in. Welcome ' . $user->name,
                'user' => ([
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                ]),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errorCode' => 'USERNAME_OR_PASSWORD_INCORRECT',
                'message' => 'username or password is incorrect',
                'user' => null
            ], 404);
        }
    }
}
