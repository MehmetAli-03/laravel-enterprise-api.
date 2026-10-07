<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Urun extends Model
{
    use HasFactory, SoftDeletes; // SoftDeletes eklendi

    protected $fillable = ['kategori_id', 'kod', 'ad', 'fiyat', 'stok'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
 * Local Scope: Arama Filtresi
 * Kullanım: Urun::arama('plastik')->get();
 */
public function scopeArama($query, ?string $arama)
{
    if (!$arama) {
        return $query;
    }

    return $query->where(function ($q) use ($arama) {
        $q->where('ad', 'like', '%' . $arama . '%')
          ->orWhere('kod', 'like', '%' . $arama . '%')
          ->orWhereHas('kategori', function ($katQuery) use ($arama) {
              $katQuery->where('ad', 'like', '%' . $arama . '%');
          });
    });
}
}