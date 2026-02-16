<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
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
                    ->circular(),
                TextColumn::make('name')
                    ->label(__('Admin.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Admin.fields.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('Admin.fields.phone'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label(__('Admin.fields.role'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'user' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin' => __('Admin.fields.admin'),
                        'user' => __('Admin.fields.user'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Admin.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('role')
                    ->label(__('Admin.fields.role'))
                    ->options([
                        'admin' => __('Admin.fields.admin'),
                        'user' => __('Admin.fields.user'),
                    ]),
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
