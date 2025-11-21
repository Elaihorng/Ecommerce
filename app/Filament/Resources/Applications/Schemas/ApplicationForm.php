<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Applicant')
                    ->relationship('user', 'full_name')
                    ->required()
                    ->searchable(),

                Forms\Components\DateTimePicker::make('submitted_at')
                    ->label('Submitted At')
                    ->default(now())
                    ->disabled()
                    ->visible(fn () => auth()->user()?->hasRole('admin') === true),    

                Forms\Components\Select::make('application_type')
                    ->label('Application Type')
                    ->options([
                        'new' => 'New License',
                        'renewal' => 'Renewal',
                        'replacement' => 'Replacement',
                    ])
                    ->required(),

                Forms\Components\Select::make('requested_license_type')
                    ->label('Requested License')
                    ->options([
                        'A1' => 'A1 - Motorcycle (≤125cc)',
                        'A'  => 'A - Motorcycle (>125cc)',
                        'B'  => 'B - Car',
                        'C'  => 'C - Truck',
                        'D'  => 'D - Bus',
                    ])
                    ->required(),

                Forms\Components\Select::make('app_status')
                    ->label('Status')
                    ->options([
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'payment_pending' => 'Payment Pending',
                        'booked_for_test' => 'Booked for Test',
                        'tested' => 'Tested',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'issued' => 'Issued',
                        'expired' => 'Expired',
                    ])
                    ->default('under_review')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
