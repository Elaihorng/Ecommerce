<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateApplication extends CreateRecord
{
    protected static string $resource = ApplicationResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        if (!auth()->user()?->hasRole('admin')) {
            // lock status for normal users
            $data['status'] = 'submitted';
        }

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    // ✅ Simple success notification (no "View" link)
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Application created')
            ->success();
        
    }
    
    
    
}
