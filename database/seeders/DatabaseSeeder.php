<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Urun; // <--- Urun Modelini buraya ekledik
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Örnek Kullanıcı
        User::create([
            'name'     => 'Mehmet Külek',
            'email'    => 'mkulek719@gmail.com',
            'password' => bcrypt('Mehmet1907'),
        ]);

        // 2. Örnek Kategoriler
        Kategori::create(['ad' => 'Plastik Enjeksiyon', 'kod' => 'KAT-01']);
        Kategori::create(['ad' => 'Ambalaj ve Paketleme', 'kod' => 'KAT-02']);
        Kategori::create(['ad' => 'Hammadde', 'kod' => 'KAT-03']);

        // 3. 50 Tane Sahte Ürün Oluştur (run metodunun İÇİNDE olmalı)
        Urun::factory(50)->create();
    }
}