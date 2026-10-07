<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Migration çalıştırıldığında (php artisan migrate) bu metot çalışır.
    public function up(): void
    {
        // 'uruns' adında bir tablo oluşturuyoruz
        Schema::create('uruns', function (Blueprint $table) {
            $table->id();                                 // BigInteger Auto-Increment Primary Key (id)

            // Yabancı Anahtar (Foreign Key) İlişkisi:
            // - foreignId('kategori_id'): Tabloya 'kategori_id' adında bir sütun ekler.
            // - constrained('kategoris'): Bu sütunu 'kategoris' tablosunun 'id' sütununa bağlar.
            // - onDelete('cascade'): Bir kategori silindiğinde ona bağlı tüm ürünleri otomatik siler (Veri bütünlüğü).
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');

            $table->string('kod')->unique();              // Ürün Kodu (benzersiz/unique index)
            $table->string('ad');                         // Ürün Adı (varchar 255)
            $table->decimal('fiyat', 10, 2);              // Toplam 10 basamak, 2 basamağı virgülden sonra (12345678.90)
            $table->integer('stok')->default(0);          // Tam sayı stok miktarı (Varsayılan: 0)
            $table->timestamps();                         // Otomatik 'created_at' ve 'updated_at' kolonları ekler
        });
    }

    // Migration geri alındığında (php artisan migrate:rollback) bu metot çalışır.
    public function down(): void
    {
        Schema::dropIfExists('uruns');
    }
};