<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderProfitExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $scope;

    public function __construct(string $scope = 'all')
    {
        $this->scope = $scope;
    }

    public function collection()
    {
        $query = match ($this->scope) {
            'today' => Order::ofToday(),
            'week' => Order::ofLastWeek(),
            'month' => Order::monthToDate(),
            default => Order::query(),
        };

        // Pastikan eager load sampai ke product
        return $query->with(['orderProducts.product'])->get();
    }

    public function map($order): array
    {
        $profit = $order->orderProducts->sum(function ($item) {
            $product = $item->product;
            if (!$product) return 0;

            $buy = $product->price ?? 0;
            $sell = $item->price ?? 0;

            return ($sell - $buy) * $item->quantity;
        });
        logger()->info("Order {$order->id} profit: $profit");

        return [
            $order->id,
            $order->created_at->format('Y-m-d'),
            $order->client_name,
            $order->total,
            $profit,
        ];
    }

    public function headings(): array
    {
        return ['ID Pesanan', 'Tanggal', 'Nama Client', 'Total Penjualan', 'Laba (Keuntungan)'];
    }
}
