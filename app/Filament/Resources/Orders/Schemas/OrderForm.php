<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('Admin.fields.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('status')
                    ->label(__('Admin.fields.status'))
                    ->options([
                        'pending' => __('Admin.fields.pending'),
                        'processing' => __('Admin.fields.processing'),
                        'shipped' => __('Admin.fields.shipped'),
                        'delivered' => __('Admin.fields.delivered'),
                        'cancelled' => __('Admin.fields.cancelled'),
                    ])
                    ->required(),
                DatePicker::make('delivery_date')
                    ->label(__('Admin.fields.delivery_date'))
                    ->validationAttribute(__('Admin.fields.delivery_date')),
                TimePicker::make('delivery_time')
                    ->label(__('Admin.fields.delivery_time'))
                    ->validationAttribute(__('Admin.fields.delivery_time')),
                TextInput::make('subtotal')
                    ->label(__('Admin.fields.subtotal'))
                    ->validationAttribute(__('Admin.fields.subtotal'))
                    ->numeric()
                    ->readOnly(),
                TextInput::make('delivery_fee')
                    ->label(__('Admin.fields.delivery_fee'))
                    ->validationAttribute(__('Admin.fields.delivery_fee'))
                    ->numeric()
                    ->required(),
                TextInput::make('total')
                    ->label(__('Admin.fields.total'))
                    ->validationAttribute(__('Admin.fields.total'))
                    ->numeric()
                    ->readOnly(),
                Select::make('address_id')
                    ->label(__('Admin.fields.image_path'))  // Reusing for address label for now
                    ->relationship('address', 'address_line_1')
                    ->searchable(),
            ]);
    }
}
