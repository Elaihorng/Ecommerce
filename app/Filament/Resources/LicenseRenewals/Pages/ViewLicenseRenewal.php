<?php

namespace App\Filament\Resources\LicenseRenewals\Pages;

use App\Filament\Resources\LicenseRenewals\LicenseRenewalResource;
use App\Models\Licenses;
use App\Models\Payment;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Mail\LicenseRenewedMail;
use Illuminate\Support\Facades\Mail;
class ViewLicenseRenewal extends ViewRecord
{
    protected static string $resource = LicenseRenewalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            // ✅ Confirm button
            Action::make('confirm')
                ->label('Confirm')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status !== 'confirmed')
                ->action(function ($record, $livewire) {

                    // 1) Get existing license by user (last one)
                    $license = Licenses::where('user_id', $record->user_id)
                        ->latest('id')
                        ->first();

                    if (! $license) {
                        Notification::make()
                            ->title('No license found for this user.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // 2) Get latest payment for this renewal (prefer renewal_id, fallback to application_id)
                    $latestPayment = Payment::where(function ($q) use ($record) {
                            $q->where('renewal_id', $record->id);
                        })
                        ->orWhere(function ($q) use ($record) {
                            $q->where('application_id', $record->application_id)
                              ->where('user_id', $record->user_id);
                        })
                        ->latest('id')
                        ->first();

                    $paymentId = $latestPayment?->id ?? null;

                    // 3) New license number + dates
                    $newLicenseNumber = 'LIC-' . strtoupper(uniqid());
                    $issuedAt  = now();
                    $expiresAt = now()->addYears(5); // or addYears(1) if you prefer

                    // 4) Update existing license
                    $license->update([
                        'license_number' => $newLicenseNumber,
                        'issued_at'      => $issuedAt,
                        'expires_at'     => $expiresAt,
                        'payment_id'     => $paymentId,
                    ]);

                    // 5) Update renewal row
                    $record->update([
                        'status'                 => 'confirmed',
                        'license_id'             => $license->id,
                        'current_license_number' => $newLicenseNumber,
                    ]);
                    // 6) Send email to user
                    $user = $record->user ?? User::find($record->user_id);

                    if ($user && ! empty($user->email)) {
                        Mail::to($user->email)->send(
                            new LicenseRenewedMail($user, $license)
                        );
                    }
                    Notification::make()
                        ->title('License updated with new number, dates, and payment.')
                        ->success()
                        ->send();

                    return $livewire->redirect(
                        static::getResource()::getUrl('index')
                    );
                }),


            // ❌ Cancel button (unchanged)
            Action::make('cancel')
                ->label('Cancel')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status !== 'cancelled')
                ->action(function ($record, $livewire) {

                    $record->update([
                        'status' => 'cancelled',
                    ]);

                    Notification::make()
                        ->title('License renewal has been cancelled.')
                        ->danger()
                        ->send();

                    return $livewire->redirect(
                        static::getResource()::getUrl('index')
                    );
                }),
        ];
    }
}
