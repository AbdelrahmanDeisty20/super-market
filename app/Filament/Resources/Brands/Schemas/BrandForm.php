<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->label(__('Admin.fields.name_en'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('name_ar')
                    ->label(__('Admin.fields.name_ar'))
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label(__('Admin.fields.image'))
                    ->image()
                    ->directory('brands')
                    ->required(),
            ]);
    }
}
