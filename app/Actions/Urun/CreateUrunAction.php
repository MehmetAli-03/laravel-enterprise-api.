<?php

namespace App\Actions\Urun;

use App\Models\Urun;

class CreateUrunAction
{
    /**
     * Yeni ürün oluşturma iş mantığı (Business Logic).
     * İleride stok alarmı verme, log atma, webhook tetikleme gibi işler buraya eklenir.
     */
    public function execute(array $data): Urun
    {
        // İş kuralı örneği: Ürün adını temizleme veya otomatik kod üretme mantıkları
        $data['ad'] = trim($data['ad']);

        return Urun::create($data);
    }
}