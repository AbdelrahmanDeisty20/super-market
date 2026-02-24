<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label(__('Admin.fields.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Admin.fields.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'info',
                        'shipped' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('Admin.fields.pending'),
                        'processing' => __('Admin.fields.processing'),
                        'shipped' => __('Admin.fields.shipped'),
                        'delivered' => __('Admin.fields.delivered'),
                        'cancelled' => __('Admin.fields.cancelled'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('total')
                    ->label(__('Admin.fields.total'))
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('delivery_date')
                    ->label(__('Admin.fields.delivery_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Admin.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label(__('Admin.fields.status'))
                    ->options([
                        'pending' => __('Admin.fields.pending'),
                        'processing' => __('Admin.fields.processing'),
                        'shipped' => __('Admin.fields.shipped'),
                        'delivered' => __('Admin.fields.delivered'),
                        'cancelled' => __('Admin.fields.cancelled'),
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->label(__('Admin.actions.view')),
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
