<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrunResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'urun_kodu'   => $this->kod,
            'urun_adi'    => $this->ad,
            // İlişkili kategori yüklendiyse JSON içinde obje olarak dönüyoruz
            'kategori'    => [
                'id'  => $this->kategori->id,
                'ad'  => $this->kategori->ad,
                'kod' => $this->kategori->kod,
            ],
            'fiyat'       => number_format($this->fiyat, 2) . ' TL',
            'stok_durumu' => $this->stok > 0 ? 'Stokta Var (' . $this->stok . ' Adet)' : 'Stok Tükendi',
            'olusturma_tarihi' => $this->created_at->format('d.m.Y H:i'),
        ];
    }
}