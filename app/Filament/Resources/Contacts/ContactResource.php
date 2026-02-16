<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\Contacts\Schemas\ContactForm;
use App\Filament\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    public static function getNavigationLabel(): string
    {
        return __('Admin.sidebar.contacts');
    }

    public static function getModelLabel(): string
    {
        return __('Admin.resources.contact.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Admin.resources.contact.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
        ];
    }
}
