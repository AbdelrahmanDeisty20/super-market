<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_ar')
                    ->label(__('Admin.fields.title_ar'))
                    ->validationAttribute(__('Admin.fields.title_ar'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('title_en')
                    ->label(__('Admin.fields.title_en'))
                    ->validationAttribute(__('Admin.fields.title_en'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('description_ar')
                    ->label(__('Admin.fields.description_ar'))
                    ->validationAttribute(__('Admin.fields.description_ar'))
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->label(__('Admin.fields.description_en'))
                    ->validationAttribute(__('Admin.fields.description_en'))
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label(__('Admin.fields.image'))
                    ->validationAttribute(__('Admin.fields.image'))
                    ->image()
                    ->directory('offers'),
                Select::make('type')
                    ->label(__('Admin.fields.type'))
                    ->validationAttribute(__('Admin.fields.type'))
                    ->options([
                        'fixed' => __('Admin.fields.text'),
                        'percentage' => __('Admin.fields.discount_percentage'),
                        'b1g1' => 'Buy 1 Get 1',  // Need translation for this
                    ])
                    ->required(),
                TextInput::make('value')
                    ->label(__('Admin.fields.discount_value'))
                    ->validationAttribute(__('Admin.fields.discount_value'))
                    ->numeric(),
                DatePicker::make('start_date')
                    ->label(__('Admin.fields.start_date'))
                    ->validationAttribute(__('Admin.fields.start_date'))
                    ->required(),
                DatePicker::make('end_date')
                    ->label(__('Admin.fields.end_date'))
                    ->validationAttribute(__('Admin.fields.end_date'))
                    ->required(),
                Toggle::make('is_active')
                    ->label(__('Admin.fields.is_active'))
                    ->validationAttribute(__('Admin.fields.is_active'))
                    ->default(true),
                Select::make('products')
                    ->label(__('Admin.sidebar.products'))
                    ->multiple()
                    ->relationship('products', 'name_ar')
                    ->preload(),
            ]);
    }
}
