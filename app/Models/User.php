<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * Veritabanındaki 'users' tablosunu temsil eden, kimlik doğrulama (Auth)
 * ve API Token yönetimi (Sanctum) özelliklerine sahip Eloquent Model sınıfı.
 */
class User extends Authenticatable
{
    /**
     * Modelde aktif edilen yetenekler (Traits):
     * - HasApiTokens: Laravel Sanctum ile API token'ları (createToken, tokens) oluşturmayı sağlar.
     * - HasFactory: Test ve sahte veri üretimi için Factory desteği sunar.
     * - Notifiable: Kullanıcıya e-posta veya sistem bildirimi gönderme yeteneği katar.
     */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Toplu atama (Mass Assignment - User::create) yöntemiyle güvenle doldurulabilecek sütunlar.
     * Güvenlik açıklarını (Guarded) önlemek için sadece izin verilen alanlar buraya yazılır.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Model JSON çıktısına (API yanıtlarına) dönüştürülürken gizlenecek hassas alanlar.
     * Kullanıcı şifresi ve hatırlatma token'larının dışarı sızmasını engeller.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Veritabanından çekilirken veya yazılırken otomatik veri tipi dönüşümü (Type Casting) yapılacak sütunlar.
     * - 'email_verified_at' => 'datetime': Metin olan tarihi Carbon nesnesine dönüştürür.
     * - 'password' => 'hashed': Şifre kaydedilirken otomatik olarak Bcrypt algoritmasıyla hash'lenir.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}