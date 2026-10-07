<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['ad', 'kod'];

    /**
     * İlişki: Bir kategorinin birden fazla ürünü olabilir (1 to N)
     */
    public function urunler(): HasMany
    {
        return $this->hasMany(Urun::class, 'kategori_id');
    }
}