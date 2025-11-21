<?php

namespace App\Filament\Resources\DriverManagement\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class DriverManagementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                // 🔹 Driver Info
                Forms\Components\TextInput::make('full_name')
                    ->label('Full Name')
                    ->afterStateHydrated(fn($set, $record) => $set('full_name', $record->user->full_name ?? ''))
                    ->disabled(),

                // Forms\Components\TextInput::make('gender')
                //     ->label('Gender')
                //     ->afterStateHydrated(fn($set, $record) => $set('gender', $record->user->gender ?? ''))
                //     ->disabled(),

                // Forms\Components\TextInput::make('dob')
                //     ->label('Date of Birth')
                //     ->afterStateHydrated(fn($set, $record) => $set('dob', $record->user->dob ?? ''))
                //     ->disabled(),

                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->afterStateHydrated(fn($set, $record) => $set('phone', $record->user->phone ?? ''))
                    ->disabled(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->afterStateHydrated(fn($set, $record) => $set('email', $record->user->email ?? ''))
                    ->disabled(),

                // Forms\Components\TextInput::make('khmer_id')
                //     ->label('Khmer ID')
                //     ->afterStateHydrated(fn($set, $record) => $set('khmer_id', $record->user->nationalIdCard->khmer_id ?? ''))
                //     ->disabled(),
                // Forms\Components\Select::make('license_type')
                //     ->label('Requested License')
                //     ->options([
                //         'A1' => 'A1 - Motorcycle (≤125cc)',
                //         'A'  => 'A - Motorcycle (>125cc)',
                //         'B'  => 'B - Car',
                //         'C'  => 'C - Truck',
                //         'D'  => 'D - Bus',
                //     ])
                    
                //      ->afterStateHydrated(fn($set, $record) => $set('license_type', $record->application->requested_license_type ?? ''))
                //     ->required(),
                // 🔹 Application Info
                Forms\Components\TextInput::make('application_type')
                    ->label('Application Type')
                    ->afterStateHydrated(fn($set, $record) => $set('application_type', $record->application->application_type ?? ''))
                    ->disabled(),

                Forms\Components\TextInput::make('permit_number')
                    ->label('Permit Number')
                    ->disabled(),

                Forms\Components\Select::make('application_status')
                    ->label('Application Status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->disabled()
                    ->afterStateHydrated(fn($set, $record) => $set('application_status', $record->application->app_status ?? ''))
                    ->required(),

                // 🔹 Booking Info
                Forms\Components\Select::make('b_status')
                    ->label('Booking Status')
                    ->options([
                        'pending' => 'Pending',
                        'Confirmed' => 'confirmed',
                        'Completed' => 'completed',
                        'Cancelled' => 'cancelled',
                    ])
                    ->disabled()
                    ->required(),

                Forms\Components\TextInput::make('test_center')
                    ->label('Test Center')
                    ->afterStateHydrated(fn($set, $record) => $set('test_center', $record->testCenter->city ?? ''))
                    ->disabled(),

                Forms\Components\DatePicker::make('test_date')
                    ->label('Test Date')
                    ->required(),

                Forms\Components\TimePicker::make('test_time')
                    ->label('Test Time')
                    ->required(),
            ]);
    }
}
