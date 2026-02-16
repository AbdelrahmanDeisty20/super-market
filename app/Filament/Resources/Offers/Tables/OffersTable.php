<?php

namespace App\Filament\Resources\Offers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label(__('Admin.fields.image'))
                    ->square(),
                TextColumn::make('title')
                    ->label(__('Admin.fields.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Admin.fields.type'))
                    ->sortable(),
                TextColumn::make('value')
                    ->label(__('Admin.fields.discount_value'))
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('Admin.fields.is_active'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label(__('Admin.fields.start_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('Admin.fields.end_date'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Admin.fields.is_active')),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('Admin.actions.edit')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('Admin.actions.delete_bulk')),
                ])->label(__('Admin.actions.bulk_actions')),
            ]);
    }
}
