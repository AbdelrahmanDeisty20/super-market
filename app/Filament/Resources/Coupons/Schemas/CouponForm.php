<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('Admin.fields.code'))
                    ->validationAttribute(__('Admin.fields.code'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('type')
                    ->label(__('Admin.fields.type'))
                    ->validationAttribute(__('Admin.fields.type'))
                    ->options([
                        'fixed' => __('Admin.fields.text'),  // Reusing 'text' for now, but should ideally have 'fixed'
                        'percentage' => __('Admin.fields.discount_percentage'),
                    ])
                    ->required(),
                TextInput::make('value')
                    ->label(__('Admin.fields.discount_value'))
                    ->validationAttribute(__('Admin.fields.discount_value'))
                    ->numeric()
                    ->required(),
                TextInput::make('min_order_value')
                    ->label(__('Admin.fields.min_order_value'))
                    ->validationAttribute(__('Admin.fields.min_order_value'))
                    ->numeric()
                    ->required(),
                DatePicker::make('start_date')
                    ->label(__('Admin.fields.start_date'))
                    ->validationAttribute(__('Admin.fields.start_date')),
                DatePicker::make('end_date')
                    ->label(__('Admin.fields.end_date'))
                    ->validationAttribute(__('Admin.fields.end_date')),
                TextInput::make('usage_limit')
                    ->label(__('Admin.fields.usage_limit'))
                    ->validationAttribute(__('Admin.fields.usage_limit'))
                    ->numeric(),
                Toggle::make('is_active')
                    ->label(__('Admin.fields.is_active'))
                    ->validationAttribute(__('Admin.fields.is_active'))
                    ->default(true),
            ]);
    }
}
