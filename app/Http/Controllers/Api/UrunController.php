<?php

namespace App\Http\Controllers\Api;
use App\Actions\Urun\CreateUrunAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUrunRequest;
use App\Http\Requests\UpdateUrunRequest;
use App\Http\Resources\UrunResource;
use App\Models\Urun;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UrunController extends Controller
{
    use ApiResponse; // Standardized JSON çıktıları için

    public function index(Request $request)
{
    // Controller içinde $query->where() kalabalığı kalmadı!
    $urunler = Urun::with('kategori')
        ->arama($request->ara)
        ->paginate(10);

    return UrunResource::collection($urunler);
}

    public function show($id)
    {
        $urun = Urun::find($id);

        if (!$urun) {
            return $this->errorResponse('Ürün bulunamadı!', 404);
        }

        return $this->successResponse(new UrunResource($urun));
    }

    // SRP: İş mantığı CreateUrunAction sınıfına devredildi
    public function store(StoreUrunRequest $request, CreateUrunAction $action)
    {
        $urun = $action->execute($request->validated());

        return $this->successResponse(new UrunResource($urun), 'Ürün başarıyla eklendi.', 201);
    }

    public function update(UpdateUrunRequest $request, $id)
    {
        $urun = Urun::find($id);

        if (!$urun) {
            return $this->errorResponse('Ürün bulunamadı!', 404);
        }

        $urun->update($request->validated());

        return $this->successResponse(new UrunResource($urun), 'Ürün güncellendi.');
    }

    // Soft Delete İşlemi
    public function destroy($id)
    {
        $urun = Urun::find($id);

        if (!$urun) {
            return $this->errorResponse('Ürün bulunamadı!', 404);
        }

        $urun->delete(); // Soft delete: deleted_at alanına tarih basar, veriyi silmez.

        return $this->successResponse(null, 'Ürün başarıyla çöp kutusuna taşındı.');
    }

    // Silinen Ürünü Geri Getirme (Restore)
    public function restore($id)
    {
        $urun = Urun::withTrashed()->find($id);

        if (!$urun) {
            return $this->errorResponse('Ürün bulunamadı!', 404);
        }

        $urun->restore(); // deleted_at alanını NULL yapar

        return $this->successResponse(new UrunResource($urun), 'Ürün başarıyla geri yüklendi.');
    }
}