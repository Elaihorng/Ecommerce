<?php

namespace App\Filament\Resources\TestResults\Pages;

use App\Filament\Resources\TestResults\TestResultResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Actions;
use App\Mail\LicenseCreatedMail;
use App\Models\Licenses;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ViewTestResult extends ViewRecord
{
    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
           Actions\Action::make('approve')
                ->label('Approve & Issue License')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->disabled(fn($record) => 
                    DB::table('licenses')
                        ->where('application_id', $record->booking->application->id ?? null)
                        ->exists()
                )
                ->action(function () {
                    $record = $this->record;

                    if ($record->theory_result !== 'pass' || $record->practical_result !== 'pass') {
                        Notification::make()
                            ->title('Both tests must be passed before issuing a license.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $newLicenseId = null;

                    // transaction: update booking/app, create license (using query builder as you had)
                    DB::transaction(function () use ($record, &$newLicenseId) {
                        $booking = $record->booking;
                        $application = $booking->application ?? null;

                        if ($booking) {
                            $booking->update(['b_status' => 'completed']);
                        }

                        if ($application) {
                            $application->update(['app_status' => 'approved']);
                        }

                        // create license if not exist and capture inserted ID
                        $exists = DB::table('licenses')
                            ->where('application_id', $application->id ?? null)
                            ->exists();

                        if (! $exists) {
                            $newLicenseId = DB::table('licenses')->insertGetId([
                                'user_id' => $record->user_id,
                                'application_id' => $application->id ?? null,
                                'permit_number' => 'PERMIT-' . strtoupper(uniqid()),
                                'license_number' => 'LIC-' . strtoupper(uniqid()),
                                'license_type' => $application->requested_license_type ?? 'B',
                                'issued_at' => now(),
                                'expires_at' => now()->addYears(5),
                                'l_status' => 'active',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        } else {
                            // if exists, fetch its id
                            $existing = DB::table('licenses')
                                ->where('application_id', $application->id ?? null)
                                ->first();
                            $newLicenseId = $existing->id ?? null;
                        }
                    });

                    // at this point transaction committed. send email if we have a license id
                    if ($newLicenseId) {
                    // try to get Eloquent models (preferred)
                    $licenseModel = Licenses::find($newLicenseId);
                    $userModel = null;

                    if ($licenseModel) {
                        $userModel = User::find($licenseModel->user_id);
                    }

                    // fallback: if Eloquent License not available (no model), use DB rows
                    if (! $licenseModel) {
                        $license = DB::table('licenses')->where('id', $newLicenseId)->first();
                    }

                    if (! $userModel) {
                        // try to fetch user from DB as fallback (stdClass)
                        $user = DB::table('users')->where('id', $license->user_id ?? $record->user_id)->first();
                    }

                    // Final decision: prefer $userModel (Eloquent), otherwise use $user (stdClass)
                    $recipientEmail = $userModel->email ?? $user->email ?? null;

                    if ($recipientEmail) {
                        try {
                            // send Eloquent models if available, otherwise pass stdClass (view must handle it)
                            if ($userModel && $licenseModel) {
                                Mail::to($recipientEmail)->send(new LicenseCreatedMail($userModel, $licenseModel));
                            } else {
                                Mail::to($recipientEmail)->send(new LicenseCreatedMail($user ?? null, $license ?? null));
                            }
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('License created but email failed to send.')
                                ->warning()
                                ->body($e->getMessage())
                                ->send();
                        }
                    } else {
                        Notification::make()
                            ->title('License created but user email not found.')
                            ->warning()
                            ->send();
                    }
                }

                    Notification::make()
                        ->title('License issued successfully!')
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),

            EditAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->redirect($this->getResource()::getUrl('index'));
    }
}
