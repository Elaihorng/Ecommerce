<?php

namespace App\Filament\Resources\DriverManagement\Pages;

use App\Filament\Resources\DriverManagement\DriverManagementResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class EditDriverManagement extends EditRecord
{
    protected static string $resource = DriverManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\ViewAction::make(),
            // Default Filament actions
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
