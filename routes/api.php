<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UrunController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Rotaları
|--------------------------------------------------------------------------
| Laravel, bu dosyadaki tüm rotaların başına otomatik olarak "/api" ekler.
| Örn: '/login' adresi -> 'http://laravel-test.test/api/login'
|
*/

// =========================================================================
// 1. HERKESE AÇIK ROTALAR (Token Gerektirmez)
// =========================================================================
Route::post('/register', [AuthController::class, 'register']); // Kullanıcı Kaydı
Route::post('/login', [AuthController::class, 'login']);       // Giriş Yapma & Token Alma


// =========================================================================
// 2. KORUMALI ROTALAR (Header'da Bearer Token Gönderilmesi Zorunludur)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {

    // Oturum İşlemleri
    Route::get('/user', function (Request $request) {
        return $request->user(); // Token sahibi kullanıcının profili
    });
    Route::post('/logout', [AuthController::class, 'logout']); // Çıkış Yapma (Token'ı İptal Etme)

    // Ürün CRUD İşlemleri
    Route::get('/urunler', [UrunController::class, 'index']);                  // Ürünleri Listele & Ara
    Route::get('/urunler/{id}', [UrunController::class, 'show']);              // Tekil Ürün Detayı
    Route::post('/urunler', [UrunController::class, 'store']);                 // Yeni Ürün Ekle (Action Katmanlı)
    Route::put('/urunler/{id}', [UrunController::class, 'update']);             // Ürün Güncelle
    Route::delete('/urunler/{id}', [UrunController::class, 'destroy']);         // Ürün Sil (Soft Delete)
    Route::post('/urunler/{id}/restore', [UrunController::class, 'restore']);  // Silinen Ürünü Geri Yükle
});