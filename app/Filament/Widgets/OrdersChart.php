<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('Admin.widgets.orders_chart.heading');
    }

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Order::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Admin.widgets.orders_chart.label'),
                    'data' => $data->map(fn(Order $order) => $order->revenue),
                    'borderColor' => '#fbbf24',
                ],
            ],
            'labels' => $data->map(fn(Order $order) => $order->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
