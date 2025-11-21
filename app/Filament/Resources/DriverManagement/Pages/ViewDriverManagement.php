<?php

namespace App\Filament\Resources\DriverManagement\Pages;

use App\Filament\Resources\DriverManagement\DriverManagementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ViewDriverManagement extends ViewRecord
{
    protected static string $resource = DriverManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 🟡 Pending
            Actions\Action::make('pending')
                ->label('Pending')
                ->color('gray')
                ->icon('heroicon-o-clock')
                ->requiresConfirmation()
                ->disabled(fn($record) => $record->b_status === 'confirmed')
                ->action(function () {
                    DB::table('bookings')
                        ->where('id', $this->record->id)
                        ->update([
                            'b_status' => 'pending',
                            'updated_at' => now(),
                        ]);

                    if ($this->record->application_id) {
                        DB::table('applications')
                            ->where('id', $this->record->application_id)
                            ->update([
                                'app_status' => 'approved',
                                'updated_at' => now(),
                            ]);
                    }

                    Notification::make()
                        ->title('Booking marked as Pending.')
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),

            // ✅ Confirmed
            Actions\Action::make('confirmed')
                ->label(fn($record) => $record->b_status === 'confirmed' ? 'Confirmed' : 'Confirm')
                ->color(fn($record) => $record->b_status === 'confirmed' ? 'gray' : 'success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->disabled(fn($record) => $record->b_status === 'confirmed')
                ->action(function () {
                    DB::transaction(function () {
                        // ✅ Update booking
                        DB::table('bookings')
                            ->where('id', $this->record->id)
                            ->update([
                                'b_status' => 'confirmed',
                                'updated_at' => now(),
                            ]);

                        // ✅ Update application
                        if ($this->record->application_id) {
                            DB::table('applications')
                                ->where('id', $this->record->application_id)
                                ->update([
                                    'app_status' => 'approved',
                                    'updated_at' => now(),
                                ]);
                        }

                        // ✅ Create test result record if missing
                        $exists = DB::table('test_results')
                            ->where('booking_id', $this->record->id)
                            ->exists();

                        if (! $exists) {
                            DB::table('test_results')->insert([
                                'booking_id' => $this->record->id,
                                'user_id' => $this->record->user_id,
                                'theory_result' => 'pending',
                                'practical_result' => 'pending',
                                'tested_at' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    });

                    Notification::make()
                        ->title('Booking confirmed and test record created successfully.')
                        ->success()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),

            // 🔴 Cancelled
            Actions\Action::make('cancelled')
                ->label('Cancel')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->disabled(fn($record) => $record->b_status === 'confirmed')
                ->action(function () {
                    DB::table('bookings')
                        ->where('id', $this->record->id)
                        ->update([
                            'b_status' => 'cancelled',
                            'updated_at' => now(),
                        ]);

                    if ($this->record->application_id) {
                        DB::table('applications')
                            ->where('id', $this->record->application_id)
                            ->update([
                                'app_status' => 'rejected',
                                'updated_at' => now(),
                            ]);
                    }

                    Notification::make()
                        ->title('Booking cancelled successfully.')
                        ->danger()
                        ->send();

                    return redirect($this->getResource()::getUrl('index'));
                }),

            EditAction::make(),
        ];
    }
}
