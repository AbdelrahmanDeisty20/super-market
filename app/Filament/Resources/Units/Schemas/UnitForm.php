<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnitForm
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
            ]);
    }
}
