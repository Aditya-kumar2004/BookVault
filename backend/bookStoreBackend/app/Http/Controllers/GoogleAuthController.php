<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller {
    public function redirect() {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback() {
        $frontendUrl = rtrim(config('app.frontend_url', 'http://localhost:8080'), '/');

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect($frontendUrl . '/login?error=google_failed');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'     => $googleUser->getName(),
                'email'    => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(24)),
                'role'     => 'user',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect(
            $frontendUrl . '/auth/google/success?token=' . $token .
            '&user=' . urlencode(json_encode([
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]))
        );
    }
}
