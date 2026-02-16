<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Admin.fields.name_ar'))
                    ->validationAttribute(__('Admin.fields.name_ar'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_en')
                    ->label(__('Admin.fields.name_en'))
                    ->validationAttribute(__('Admin.fields.name_en'))
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
                TextInput::make('price')
                    ->label(__('Admin.fields.price'))
                    ->validationAttribute(__('Admin.fields.price'))
                    ->numeric()
                    ->required(),
                TextInput::make('discount_price')
                    ->label(__('Admin.fields.discount_price'))
                    ->validationAttribute(__('Admin.fields.discount_price'))
                    ->numeric(),
                TextInput::make('stock')
                    ->label(__('Admin.fields.stock'))
                    ->validationAttribute(__('Admin.fields.stock'))
                    ->numeric()
                    ->required(),
                Select::make('category_id')
                    ->label(__('Admin.fields.category'))
                    ->validationAttribute(__('Admin.fields.category'))
                    ->relationship('category', 'name_ar')
                    ->required(),
                Select::make('brand_id')
                    ->label(__('Admin.fields.brand'))
                    ->validationAttribute(__('Admin.fields.brand'))
                    ->relationship('brand', 'name_ar')
                    ->required(),
                Select::make('unit_id')
                    ->label(__('Admin.fields.unit'))
                    ->validationAttribute(__('Admin.fields.unit'))
                    ->relationship('unit', 'name_ar')
                    ->required(),
                TextInput::make('min_quantity')
                    ->label(__('Admin.fields.min_quantity'))
                    ->validationAttribute(__('Admin.fields.min_quantity'))
                    ->numeric()
                    ->default(1),
                TextInput::make('step_quantity')
                    ->label(__('Admin.fields.step_quantity'))
                    ->validationAttribute(__('Admin.fields.step_quantity'))
                    ->numeric()
                    ->default(1),
                Toggle::make('is_featured')
                    ->label(__('Admin.fields.is_featured'))
                    ->validationAttribute(__('Admin.fields.is_featured'))
                    ->default(false),
            ]);
    }
}
