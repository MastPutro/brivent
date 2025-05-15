<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use App\Models\SupplyInBarcode;

class Report extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static string $view = 'filament.pages.report';
    protected static ?string $navigationGroup = 'Laporan';

    public $data = [];

    public function mount(): void
    {
        $this->data = [
            'stok' => Product::all()->map(fn ($p) => [
                'name' => $p->name,
                'value' => $p->quantity,
            ]),

            'rusak' => Product::withCount(['barcodes as damaged_count' => fn ($q) => $q->whereHas('damaged')])
                ->get()
                ->map(fn ($p) => [
                    'name' => $p->name,
                    'value' => $p->damaged_count,
                ]),
        ];
    }
}
