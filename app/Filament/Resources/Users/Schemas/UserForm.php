<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use App\Models\Role;
class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->unique(ignoreRecord: true)
                    ->maxLength(30),

                Forms\Components\Select::make('role_id')
                ->label('Assign Role')
                ->options(Role::pluck('name', 'id')->toArray())
                ->searchable()
                ->required()
                ->preload()
                ->helperText('Select the role for this user'),

                Forms\Components\TextInput::make('password_hash')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state))
                    ->revealable(),

                Forms\Components\Select::make('preferred_language')
                    ->label('Language')
                    ->options([
                        'kh' => 'Khmer',
                        'en' => 'English',
                    ])
                    ->default('kk'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                Forms\Components\DateTimePicker::make('last_login_at')
                    ->label('Last Login')
                    ->disabled(),
            ]);
    }
}
