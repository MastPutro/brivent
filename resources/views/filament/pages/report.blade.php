<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-filament::card>
            <x-slot name="header">Stok Produk</x-slot>
            <div
                class="h-72"
                x-data
                x-init="
                    () => {
                        const el = $el;
                        const data = @js($data['stok']);
                        const chart = echarts.init(el);
                        chart.setOption({
                            tooltip: { trigger: 'item' },
                            series: [{
                                type: 'pie',
                                radius: '60%',
                                data: data,
                            }]
                        });
                    }
                "
            ></div>
        </x-filament::card>

        <x-filament::card>
            <x-slot name="header">Produk Rusak</x-slot>
            <div
                class="h-72"
                x-data
                x-init="
                    () => {
                        const el = $el;
                        const data = @js($data['rusak']);
                        const chart = echarts.init(el);
                        chart.setOption({
                            tooltip: { trigger: 'item' },
                            series: [{
                                type: 'pie',
                                radius: '60%',
                                data: data,
                            }]
                        });
                    }
                "
            ></div>
        </x-filament::card>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        <a
            href="{{ route('report.export') }}"
            class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition"
        >
            📁 Export Laporan Produk
        </a>
        <a href="{{ route('orders.report.export', 'month') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
            🗓️ Export Bulan Ini
        </a>
        <a href="{{ route('orders.report.export') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
            📁 Export Semua
        </a>
    </div>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    </x-slot>
</x-filament::page>
