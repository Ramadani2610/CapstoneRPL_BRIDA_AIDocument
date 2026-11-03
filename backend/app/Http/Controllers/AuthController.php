<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Authentication — the entry point for every user.
 *
 * Reference implementation for the other controllers: validate, act, answer JSON.
 */
class AuthController extends Controller
{
    /**
     * POST /api/login — public.
     *
     * 200: { token, user } · 422: wrong credentials · 403: account disabled
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau kata sandi salah.'], 422);
        }

        if (! $user->aktif) {
            return response()->json(['message' => 'Akun ini dinonaktifkan. Hubungi administrator.'], 403);
        }

        $user->forceFill(['login_terakhir' => now()])->save();

        return response()->json([
            'token' => $user->createToken('sigap-web')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'instansi' => $user->instansi,
            ],
        ]);
    }

    /**
     * POST /api/logout — requires login. Deletes the current token, 204.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(null, 204);
    }

    /**
     * GET /api/me — requires login. Profile of the current user, 200.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'instansi' => $user->instansi,
            'aktif' => $user->aktif,
        ]);
    }
}
