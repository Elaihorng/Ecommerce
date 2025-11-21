<?php

namespace App\Filament\Resources\Licenses\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class LicenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('License Holder')
                    ->relationship('user', 'full_name')
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('license_number')
                    ->label('License Number')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('license_type')
                    ->label('License Type')
                    ->options([
                        'A1' => 'A1 - Motorcycle (≤125cc)',
                        'A' => 'A - Motorcycle (>125cc)',
                        'B' => 'B - Car',
                        'C' => 'C - Truck',
                        'D' => 'D - Bus',
                    ])
                    ->required(),

                Forms\Components\DatePicker::make('issued_at')
                    ->label('Issued Date')
                    ->required(),

                Forms\Components\DatePicker::make('expires_at')
                    ->label('Expiry Date')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'suspended' => 'Suspended',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
