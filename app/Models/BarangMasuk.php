<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($barangMasuk) {
            $product = $barangMasuk->product;

            $allBarangMasuk = $product->barangMasuks;

            $totalQty = $allBarangMasuk->sum('quantity');
            $totalHarga = $allBarangMasuk->sum(fn ($bm) => $bm->quantity * $bm->price);

            $averagePrice = $totalQty > 0 ? $totalHarga / $totalQty : 0;

            $product->update([
                'price' => $averagePrice,
                'quantity' => $product->quantity + $barangMasuk->quantity,
            ]);
        });
    }
}
