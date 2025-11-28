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
}
