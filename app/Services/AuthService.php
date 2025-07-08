<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use League\Config\Exception\ValidationException;

class AuthService
{

    /**
     * Summary of login
     * @param string $email
     * @param string $password
     * @throws \Exception
     * @return User
     */
    

    public function login(string $email, string $password): User
    {
        $key = 'login_attempts:' . request()->ip();
        RateLimiter::hit($key, 60); // السماح بمحاولة واحدة كل 60 ثانية

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'تم تجاوز الحد المسموح لمحاولات تسجيل الدخول. الرجاء المحاولة لاحقًا.',
            ]);
        }

        $user = User::where('email', $email)->firstOrFail();
        if (!Hash::check($password, $user->password)) {
            throw new \Exception('بيانات الدخول غير صحيحة');
        }
        return $user;
    }
}
