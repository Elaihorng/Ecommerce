<?php

namespace App\Filament\Resources\TestResults\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\TestResults\Pages\ListTestResults;
class TestResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                // 👤 User
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'full_name')
                    ->searchable()
                    ->label('Driver')
                    ->required(),

                // 📋 Booking
                Forms\Components\Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->label('Booking IdD')
                    ->required(),

                // 📘 Theory Result
                Forms\Components\Select::make('theory_result')
                    ->label('Theory Test Result')
                    ->options([
                        'pending' => 'Pending',
                        'pass' => 'Pass',
                        'fail' => 'Fail',
                    ])
                    ->required(),

                // 🚗 Practical Result
                Forms\Components\Select::make('practical_result')
                    ->label('Practical Test Result')
                    ->options([
                        'pending' => 'Pending',
                        'pass' => 'Pass',
                        'fail' => 'Fail',
                    ])
                    ->required(),

                // 📝 Remarks
                Forms\Components\Textarea::make('remarks')
                    ->label('Remarks')
                    ->maxLength(1000),

                // 🕒 Test Date
                Forms\Components\DateTimePicker::make('tested_at')
                    ->label('Tested At')
                    ->default(now())
                    ->required(),
            ]);
    }

    /**
     * Hook after saving — issue license if both passed.
     */



public static function afterSave($record): void
{
    try {
        // only when both tests are passed
        if ($record->theory_result === 'pass' && $record->practical_result === 'pass') {
            DB::transaction(function () use ($record) {
                $booking = $record->booking;
                $application = $booking->application ?? null;

                // ✅ update booking + application
                if ($booking) {
                    $booking->update(['b_status' => 'completed']);
                }

                if ($application) {
                    $application->update(['app_status' => 'approved']);
                }

                // 🪪 create license if not exist
                $exists = DB::table('licenses')
                    ->where('application_id', $application->id ?? null)
                    ->exists();

                if (! $exists) {
                    DB::table('licenses')->insert([
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
                }
            });

            Notification::make()
                ->title('License issued successfully! Both tests passed.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Test results saved.')
                ->info()
                ->send();
        }
    } catch (\Throwable $e) {
        Notification::make()
            ->title('Error: ' . $e->getMessage())
            ->danger()
            ->send();
    }
}



}
