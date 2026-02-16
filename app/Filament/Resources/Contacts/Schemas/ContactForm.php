<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Admin.fields.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label(__('Admin.fields.phone'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('message')
                    ->label(__('Admin.fields.content'))
                    ->required(),
            ]);
    }
}
