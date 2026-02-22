<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class InventoryChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('Admin.widgets.inventory_chart.heading');
    }

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $products = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Admin.widgets.inventory_chart.label'),
                    'data' => $products->pluck('stock')->toArray(),
                    'backgroundColor' => '#ef4444',
                ],
            ],
            'labels' => $products->map(fn($product) => $product->name)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
