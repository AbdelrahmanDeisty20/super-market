<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Admin.fields.name'))
                    ->validationAttribute(__('Admin.fields.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('Admin.fields.email'))
                    ->validationAttribute(__('Admin.fields.email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label(__('Admin.fields.phone'))
                    ->validationAttribute(__('Admin.fields.phone'))
                    ->tel()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label(__('Admin.fields.password') ?? 'Password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(255),
                Select::make('role')
                    ->label(__('Admin.fields.role'))
                    ->validationAttribute(__('Admin.fields.role'))
                    ->options([
                        'admin' => __('Admin.fields.admin'),
                        'user' => __('Admin.fields.user'),
                    ])
                    ->required(),
                FileUpload::make('image')
                    ->label(__('Admin.fields.image'))
                    ->validationAttribute(__('Admin.fields.image'))
                    ->image()
                    ->directory('users'),
            ]);
    }
}
