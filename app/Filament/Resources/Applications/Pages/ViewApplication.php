<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Actions\EditAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
             Actions\Action::make('under_review')
        ->label('Under Review')
        ->color('warning')
        ->icon('heroicon-o-eye')
        ->requiresConfirmation()
        ->disabled(fn($record) => $record->app_status === 'approved')
        ->action(function ($record) {
            DB::transaction(function () use ($record) {
                $record->update(['app_status' => 'under_review']);
            });

            Notification::make()
                ->title('Application marked as Under Review.')
                ->success()
                ->send();

            return redirect($this->getResource()::getUrl('index'));
        }),

    // ✅ Approve
    Actions\Action::make('approve')
        ->label(fn($record) => $record->app_status === 'approved'
            ? 'Approved'
            : 'Approve'
        )
        ->color(fn($record) => $record->app_status === 'approved'
            ? 'gray'
            : 'success'
        )
        ->icon('heroicon-o-check-circle')
        ->requiresConfirmation()
        ->disabled(fn($record) => $record->app_status === 'approved')
        ->action(function ($record) {
            DB::transaction(function () use ($record) {
                $record->update(['app_status' => 'approved']);
            });

            Notification::make()
                ->title('Application approved successfully.')
                ->success()
                ->send();

            return redirect($this->getResource()::getUrl('index'));
        }),

    // 🔴 Reject
    Actions\Action::make('reject')
        ->label('Reject')
        ->color('danger')
        ->icon('heroicon-o-x-circle')
        ->requiresConfirmation()
        ->disabled(fn($record) => $record->app_status === 'approved')
        ->action(function ($record) {
            DB::transaction(function () use ($record) {
                $record->update(['app_status' => 'rejected']);
            });

            Notification::make()
                ->title('Application rejected.')
                ->danger()
                ->send();

            return redirect($this->getResource()::getUrl('index'));
        }),
            EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
