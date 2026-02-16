<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Filament\Resources\Settings\Schemas\SettingForm;
use App\Filament\Resources\Settings\Tables\SettingsTable;
use App\Models\Setting;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'key';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getNavigationLabel(): string
    {
        return __('Admin.sidebar.settings');
    }

    public static function getModelLabel(): string
    {
        return __('Admin.resources.setting.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Admin.resources.setting.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return SettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsTable::configure($table);
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
            'index' => ListSettings::route('/'),
        ];
    }
}
