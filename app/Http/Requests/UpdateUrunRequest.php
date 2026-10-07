<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUrunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Güncellenen ürünün kendi ID'sini alıyoruz
        $urunId = $this->route('id');

        return [
            'kategori_id' => 'required|integer|exists:kategoris,id',
            'kod'      => 'sometimes|string|unique:uruns,kod,' . $urunId,
            'ad'       => 'sometimes|string',
            'fiyat'    => 'sometimes|numeric|min:0',
            'stok'     => 'sometimes|integer|min:0',
        ];
    }
}