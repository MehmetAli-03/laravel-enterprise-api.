<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * Laravel Sanctum altyapısını kullanarak Kayıt, Giriş ve Çıkış (Token) işlemlerini yöneten Kontrolcü.
 */
class AuthController extends Controller
{
    /**
     * Yeni kullanıcı kaydı (Register) oluşturur ve anında erişim token'ı üretir.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Gelen isteğin verilerini doğruluyoruz (Validasyon)
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email', // E-postanın veritabanında benzersiz olması şart
            'password' => 'required|string|min:6',
        ]);

        // Veritabanına yeni kullanıcı kaydını ekliyoruz
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // Şifreyi güvenli algoritmayla (Bcrypt) hash'liyoruz
        ]);

        // User modelindeki HasApiTokens trait'i sayesinde kullanıcıya özel Sanctum API token'ı üretiyoruz
        $token = $user->createToken('api_token')->plainTextToken;

        // Üretilen token ve kullanıcı verisini 201 Created yanıtı ile istemciye dönüyoruz
        return response()->json([
            'status' => true,
            'mesaj'  => 'Kullanıcı başarıyla oluşturuldu.',
            'token'  => $token,
            'user'   => $user
        ], 201);
    }

    /**
     * Kullanıcı girişi (Login) yapar, doğrulama başarılıysa erişim token'ı teslim eder.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Giriş parametrelerinin varlığını kontrol ediyoruz
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // E-posta adresiyle eşleşen kullanıcıyı buluyoruz
        $user = User::where('email', $request->email)->first();

        // Kullanıcı yoksa VEYA girilen açık şifre hash'lenmiş şifre ile eşleşmiyorsa yetkilendirme hatası dönüyoruz
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'mesaj'  => 'E-posta veya şifre hatalı!'
            ], 401);
        }

        // Güvenlik amacıyla kullanıcının önceden aldığı tüm aktif token'ları iptal edip temizliyoruz
        $user->tokens()->delete();

        // Yeni oturum için taze bir token üretiyoruz
        $token = $user->createToken('api_token')->plainTextToken;

        // Başarılı giriş yanıtını ve token'ı 200 OK ile dönüyoruz
        return response()->json([
            'status' => true,
            'mesaj'  => 'Giriş başarılı.',
            'token'  => $token
        ], 200);
    }

    /**
     * Oturumu kapatır (Logout) ve isteği atan token'ı geçersiz kılar.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // İstekte bulunan yetkilendirilmiş (Authenticated) kullanıcının o an kullandığı token'ı veritabanından siliyoruz
        $request->user()->currentAccessToken()->delete();

        // İptal işleminin başarılı yanıtını dönüyoruz
        return response()->json([
            'status' => true,
            'mesaj'  => 'Çıkış yapıldı, token iptal edildi.'
        ], 200);
    }
}