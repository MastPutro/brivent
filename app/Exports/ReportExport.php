<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Product::withCount([
            'barcodes as damaged_count' => fn ($q) => $q->whereHas('damaged'),
        ])->get();
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->quantity,
            'XFA ' . number_format($product->price),
            $product->damaged_count,
        ];
    }

    public function headings(): array
    {
        return ['Nama Produk', 'Stok', 'Harga per Unit', 'Jumlah Rusak'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // baris pertama = header
        ];
    }
}
