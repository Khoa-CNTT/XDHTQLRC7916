<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->redirect()->getTargetUrl()
        ]);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Tìm hoặc tạo mới user
            $user = KhachHang::firstOrCreate(
                ['google_id' => $googleUser->id],
                [
                    'ten_khach_hang' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(12)),
                    're_password' => bcrypt(Str::random(12)),
                    'so_dien_thoai' => 'N/A'
                ]
            );

            // Nếu email đã tồn tại nhưng chưa có google_id
            if (!$user->google_id) {
                $user->google_id = $googleUser->id;
                $user->save();
            }

            // Tạo token
            $token = $user->createToken('google-auth-token')->plainTextToken;

            // Trả về redirect với token
            return redirect("http://localhost:5173/auth/callback?token={$token}&name={$user->ten_khach_hang}&id={$user->id}");
        } catch (\Exception $e) {
            return redirect("http://localhost:5173/login?error=google_login_failed&message=" . urlencode($e->getMessage()));
        }
    }
}