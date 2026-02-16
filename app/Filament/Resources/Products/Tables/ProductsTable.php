<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('Admin.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('Admin.fields.price'))
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label(__('Admin.fields.stock'))
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label(__('Admin.fields.category'))
                    ->sortable(),
                TextColumn::make('brand.name')
                    ->label(__('Admin.fields.brand'))
                    ->sortable(),
                \Filament\Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('Admin.fields.is_featured'))
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Admin.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->label(__('Admin.fields.category'))
                    ->relationship('category', 'name_ar'),
                \Filament\Tables\Filters\SelectFilter::make('brand_id')
                    ->label(__('Admin.fields.brand'))
                    ->relationship('brand', 'name_ar'),
                \Filament\Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('Admin.fields.is_featured')),
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
