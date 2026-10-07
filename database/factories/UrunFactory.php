<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Urun;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrunFactory extends Factory
{
    protected $model = Urun::class;

    public function definition(): array
    {
        return [
            // Veritabanındaki kategorilerden rastgele birinin ID'sini çeker
            'kategori_id' => Kategori::inRandomOrder()->first()?->id ?? 1,
            'kod'         => 'PRD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'ad'          => ucfirst($this->faker->words(3, true)),
            'fiyat'       => $this->faker->randomFloat(2, 10, 500),
            'stok'        => $this->faker->numberBetween(0, 150),
        ];
    }
}