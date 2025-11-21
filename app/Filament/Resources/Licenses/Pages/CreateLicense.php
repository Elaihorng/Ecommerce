<?php

namespace App\Filament\Resources\Licenses\Pages;

use App\Filament\Resources\Licenses\LicenseResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateLicense extends CreateRecord
{
    protected static string $resource = LicenseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Assign current user as license holder
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        // Set default values for normal users
        if (!auth()->user()?->hasRole('admin')) {
            $data['status'] = 'active';
            $data['issued_at'] = now();
            $data['expires_at'] = now()->addYears(1);
        }

        return $data;
    }

    // ✅ Prevent "missing record" error — go back to list after creating
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    // ✅ Clean success message
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('License created successfully')
            ->success();
    }
}
