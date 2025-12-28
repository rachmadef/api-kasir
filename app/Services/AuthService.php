<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(protected UserRepository $users) {}

    public function login($email, $password, $role = null)
    {
        $user = $this->users->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        // Jika role dikirim → pastikan cocok
        if ($role && $user->role !== $role) {
            throw ValidationException::withMessages([
                'role' => ['Role tidak sesuai']
            ]);
        }

        // 🔴 Cek status
        if ($user->status !== 'Aktif') {
            throw ValidationException::withMessages([
                'status' => ['Akun Anda tidak aktif. Silakan hubungi admin.']
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user
        ];
    }
}
