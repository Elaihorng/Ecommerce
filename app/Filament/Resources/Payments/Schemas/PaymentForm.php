<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'full_name')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('application_id')
                    ->label('Application')
                    ->relationship('application', 'id')
                    ->searchable(),

                Forms\Components\TextInput::make('amount')
                    ->label('Amount (KHR)')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('currency')
                    ->default('KHR')
                    ->required(),

                Forms\Components\TextInput::make('provider')
                    ->label('Payment Provider')
                    ->placeholder('ABA, Wing, ACLEDA, etc.')
                    ->maxLength(64)
                    ->required(),

                Forms\Components\TextInput::make('provider_payment_id')
                    ->label('Provider Payment ID')
                    ->maxLength(128),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->default('pending')
                    ->required(),

                Forms\Components\DatePicker::make('paid_at')
                    ->label('Paid Date')
                    ->native(false)
                    ->suffixIcon('heroicon-m-calendar'),
            ]);
    }
}
