<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceForm
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
                Textarea::make('content_ar')
                    ->label(__('Admin.fields.content_ar'))
                    ->validationAttribute(__('Admin.fields.content_ar'))
                    ->required(),
                Textarea::make('content_en')
                    ->label(__('Admin.fields.content_en'))
                    ->validationAttribute(__('Admin.fields.content_en'))
                    ->required(),
            ]);
    }
}
