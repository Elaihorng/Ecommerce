<?php

namespace App\Filament\Resources\LicenseRenewals\Pages;

use App\Filament\Resources\LicenseRenewals\LicenseRenewalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLicenseRenewal extends EditRecord
{
    protected static string $resource = LicenseRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
