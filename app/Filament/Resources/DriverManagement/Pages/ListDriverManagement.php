<?php

namespace App\Filament\Resources\DriverManagement\Pages;

use App\Filament\Resources\DriverManagement\DriverManagementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverManagement extends ListRecords
{
    protected static string $resource = DriverManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
