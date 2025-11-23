<?php

namespace App\Filament\Resources\LicenseRenewals\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class LicenseRenewalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([

                // 👤 Applicant
                Forms\Components\Select::make('user_id')
                    ->label('Applicant')
                    ->relationship('user', 'full_name')
                    ->required()
                    ->searchable(),

                // 🪪 Related Application (optional)
                Forms\Components\Select::make('application_id')
                    ->label('Application')
                    ->relationship('application', 'id')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                // 🎫 Related License (optional)
                Forms\Components\Select::make('license_id')
                    ->label('License')
                    ->relationship('license', 'license_number')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                // 🧾 National ID (raw value if you don’t have relation)
                Forms\Components\TextInput::make('national_id')
                    ->label('National ID')
                    ->numeric()
                    ->nullable(),

                // 🔢 Permit Number
                Forms\Components\TextInput::make('permit_number')
                    ->label('Permit Number')
                    ->maxLength(50)
                    ->required(),

                // 📎 Reference
                Forms\Components\TextInput::make('reference')
                    ->label('Reference')
                    ->maxLength(191)
                    ->nullable(),

                // 🔢 Current License Number
                Forms\Components\TextInput::make('current_license_number')
                    ->label('Current License No.')
                    ->maxLength(255)
                    ->nullable(),

                // 🚚 Delivery Option
                Forms\Components\Select::make('delivery_option')
                    ->label('Delivery Option')
                    ->options([
                        'pickup'   => 'Pickup at Center',
                        'delivery' => 'Home Delivery',
                    ])
                    ->required(),

                // 📍 Delivery Address
                Forms\Components\Textarea::make('delivery_address')
                    ->label('Delivery Address')
                    ->rows(3)
                    ->columnSpanFull()
                    ->nullable(),

                // 📊 Status
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'submitted' => 'Submitted',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('submitted')
                    ->required(),
            ]);
    }
}
