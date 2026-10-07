<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrunRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // İstek iznini onaylıyoruz
    }

    public function rules(): array
{
    return [
        'kategori_id' => 'required|integer|exists:kategoris,id',
        'kod'         => 'required|string|unique:uruns,kod',
        'ad'          => 'required|string|max:255',
        'fiyat'       => 'required|numeric|min:0',
        'stok'        => 'required|integer|min:0',
    ];
}
}