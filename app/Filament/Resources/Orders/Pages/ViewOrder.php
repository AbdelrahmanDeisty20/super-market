<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('changeStatus')
                ->label(__('Admin.actions.change_status'))
                ->icon('heroicon-o-arrow-path')
                ->form([
                    Select::make('status')
                        ->label(__('Admin.fields.status'))
                        ->options([
                            'pending' => __('Admin.fields.pending'),
                            'shipped' => __('Admin.fields.shipped'),
                            'delivered' => __('Admin.fields.delivered'),
                            'cancelled' => __('Admin.fields.cancelled'),
                        ])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => $data['status'],
                    ]);
                }),
        ];
    }
}
