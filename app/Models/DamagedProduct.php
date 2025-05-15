<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'supply_in_barcode_id',
        'damaged_at',
        'reason',
        'notes',
    ];
    protected static function booted(): void
    {
        static::creating(function ($damage) {
            // Cek apakah barcode sudah pernah dicatat rusak
            $barcode = \App\Models\SupplyInBarcode::findOrFail($damage->supply_in_barcode_id);
            if ($barcode->damaged) {
                throw new \Exception("Barcode ini sudah pernah dicatat sebagai rusak.");
            }

            // Kurangi stok produk
            $product = $barcode->product;
            if ($product) {
                $product->decrement('quantity', 1);
            }
        });
        static::created(function ($damage) {
            $damage->barcode->product?->supplyIns()->first()?->updateProductAverage();
        });

        static::deleted(function ($damage) {
            $damage->barcode->product?->supplyIns()->first()?->updateProductAverage();
        });
    }

    public function barcode()
    {
        return $this->belongsTo(\App\Models\SupplyInBarcode::class, 'supply_in_barcode_id');
    }
}
