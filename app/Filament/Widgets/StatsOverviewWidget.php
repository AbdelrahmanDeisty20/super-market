<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('Admin.widgets.stats.orders'), Order::count())
                ->description(__('Admin.widgets.stats.orders_desc'))
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success'),
            Stat::make(__('Admin.widgets.stats.revenue'), number_format(Order::sum('total'), 2) . ' ' . (app()->isLocale('ar') ? 'ج.م' : 'EGP'))
                ->description(__('Admin.widgets.stats.revenue_desc'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            Stat::make(__('Admin.widgets.stats.customers'), User::count())
                ->description(__('Admin.widgets.stats.customers_desc'))
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
