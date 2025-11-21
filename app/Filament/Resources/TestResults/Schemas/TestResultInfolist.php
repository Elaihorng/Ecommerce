<?php

namespace App\Filament\Resources\TestResults\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class TestResultInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(3)->schema([

                // 👤 Driver Info
                TextEntry::make('user.full_name')
                    ->label('Driver Name')
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->color('primary')
                    ->extraAttributes([
                        'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                    ]),

                TextEntry::make('user.phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->color('info'),

                TextEntry::make('user.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable(),

                // 🧾 Booking Info
                TextEntry::make('booking.id')
                    ->label('Booking ID')
                    ->icon('heroicon-o-identification')
                    ->copyable()
                    ->color('primary')
                    ->extraAttributes([
                        'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                    ]),

                TextEntry::make('booking.b_status')
                    ->label('Booking Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                // 📘 Theory Result
                TextEntry::make('theory_result')
                    ->label('Theory Test')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'pass' => 'success',
                        'fail' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn(string $state) => match ($state) {
                        'pass' => 'heroicon-o-check-circle',
                        'fail' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-clock',
                    }),

                // 🚗 Practical Result
                TextEntry::make('practical_result')
                    ->label('Practical Test')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'pass' => 'success',
                        'fail' => 'danger',
                        'pending' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn(string $state) => match ($state) {
                        'pass' => 'heroicon-o-check-circle',
                        'fail' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-clock',
                    }),

                // 🕒 Tested Date
                TextEntry::make('tested_at')
                    ->label('Tested At')
                    ->dateTime()
                    ->icon('heroicon-o-calendar-days'),

                // 🧠 Remarks
                TextEntry::make('remarks')
                    ->label('Remarks')
                    ->placeholder('No remarks provided')
                    ->columnSpanFull()
                    ->extraAttributes([
                        'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                    ]),
            ]),
        ]);
    }
}
