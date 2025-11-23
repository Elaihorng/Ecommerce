<?php

namespace App\Filament\Resources\LicenseRenewals\Pages;

use App\Filament\Resources\LicenseRenewals\LicenseRenewalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicenseRenewals extends ListRecords
{
    protected static string $resource = LicenseRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
