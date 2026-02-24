<?php

namespace App\Filament\Resources\Orders\Infolists;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Admin.fields.customer_info'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label(__('Admin.fields.name')),
                                TextEntry::make('user.phone')
                                    ->label(__('Admin.fields.phone')),
                                TextEntry::make('user.email')
                                    ->label(__('Admin.fields.email')),
                            ]),
                    ])
                    ->collapsible(),
                Section::make(__('Admin.fields.address_info'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('address.label')
                                    ->label(__('Admin.fields.label')),
                                TextEntry::make('address.address')
                                    ->label(__('Admin.fields.address')),
                            ]),
                    ])
                    ->collapsible(),
                Section::make(__('Admin.fields.order_summary'))
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('status')
                                    ->label(__('Admin.fields.status'))
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'pending' => 'gray',
                                        'processing' => 'info',
                                        'shipped' => 'warning',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('delivery_date')
                                    ->label(__('Admin.fields.delivery_date'))
                                    ->date(),
                                TextEntry::make('delivery_time')
                                    ->label(__('Admin.fields.delivery_time')),
                                TextEntry::make('total')
                                    ->label(__('Admin.fields.total'))
                                    ->money('EGP')
                                    ->weight('bold')
                                    ->color('primary'),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('subtotal')
                                    ->label(__('Admin.fields.subtotal'))
                                    ->money('EGP'),
                                TextEntry::make('delivery_fee')
                                    ->label(__('Admin.fields.delivery_fee'))
                                    ->money('EGP'),
                                TextEntry::make('discount')
                                    ->label(__('Admin.fields.discount_value'))
                                    ->money('EGP'),
                            ]),
                    ])
                    ->collapsible(),
                Section::make(__('Admin.sidebar.products'))
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextEntry::make('product.name')
                                            ->label(__('Admin.fields.name')),
                                        TextEntry::make('quantity')
                                            ->label(__('Admin.fields.stock')),  // reusing stock for quantity label
                                        TextEntry::make('price')
                                            ->label(__('Admin.fields.price'))
                                            ->money('EGP'),
                                        TextEntry::make('total_item_price')
                                            ->label(__('Admin.fields.total'))
                                            ->state(fn($record) => $record->quantity * $record->price)
                                            ->money('EGP'),
                                    ]),
                            ])
                            ->label('')
                            ->columns(1),
                    ]),
            ]);
    }
}
