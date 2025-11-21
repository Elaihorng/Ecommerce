<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        // Avoid generating users.view URL with a missing {record}
        return static::getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        // Simple success notification without a “View” action/link
        return \Filament\Notifications\Notification::make()
            ->title('User created')
            ->success();
    }
    protected function afterCreate(): void
    {
        $record = $this->record; // the newly created user
        $selectedRoleId = $this->data['role_id'] ?? null;

        if ($selectedRoleId) {
            \Illuminate\Support\Facades\DB::table('user_roles')->insert([
                'user_id' => $record->id,
                'role_id' => $selectedRoleId,
                'assigned_at' => now(),
            ]);
        }
    }

}
