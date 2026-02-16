<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label(__('Admin.fields.key'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('type')
                    ->label(__('Admin.fields.type'))
                    ->options([
                        'text' => __('Admin.fields.text'),
                        'image' => __('Admin.fields.image'),
                        'json' => __('Admin.fields.json'),
                    ])
                    ->required()
                    ->reactive(),
                Textarea::make('value')
                    ->label(__('Admin.fields.value'))
                    ->visible(fn($get) => $get('type') !== 'image'),
                FileUpload::make('value')
                    ->label(__('Admin.fields.image'))
                    ->image()
                    ->directory('settings')
                    ->visible(fn($get) => $get('type') === 'image'),
            ]);
    }
}
