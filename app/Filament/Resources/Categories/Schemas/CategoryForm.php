<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Admin.fields.name_ar'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_en')
                    ->label(__('Admin.fields.name_en'))
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label(__('Admin.fields.image'))
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->required(),
                Toggle::make('is_visible')
                    ->label(__('Admin.fields.is_visible'))
                    ->default(true),
            ]);
    }
}
