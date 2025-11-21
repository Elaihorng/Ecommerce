<?php

namespace App\Filament\Resources\DriverManagement\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class DriverManagementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(3)->schema([

                // 🧍 Driver info
                \Filament\Infolists\Components\TextEntry::make('user.full_name')
                    ->label('Full Name')
                    ->icon('heroicon-o-user')
                    ->weight('bold')
                    ->color('primary')
                    ->extraAttributes([
                            'class' => 'border border-gray-700 rounded-md p-2 bg-gray-900/40',
                        ]),

                // \Filament\Infolists\Components\TextEntry::make('user.gender')
                //     ->label('Gender')
                //     ->icon('heroicon-o-identification'),

                // \Filament\Infolists\Components\TextEntry::make('user.dob')
                //     ->label('Date of Birth')
                //     ->date()
                //     ->icon('heroicon-o-calendar'),

                \Filament\Infolists\Components\TextEntry::make('user.phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->color('info'),

                \Filament\Infolists\Components\TextEntry::make('user.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->copyable(),

                // \Filament\Infolists\Components\TextEntry::make('user.nationalIdCard.khmer_id')
                //     ->label('Khmer ID')
                //     ->icon('heroicon-o-identification')
                //     ->color('gray'),
                 \Filament\Infolists\Components\TextEntry::make('application.requested_license_type')
                        ->label('License Type')
                        ->icon('heroicon-o-identification')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),        
                // 📄 Application info
                \Filament\Infolists\Components\TextEntry::make('application.application_type')
                    ->label('Application Type')
                    ->icon('heroicon-o-document-text'),

                \Filament\Infolists\Components\TextEntry::make('application.app_status')
                    ->label('Application Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'approved' => 'success',
                        'under_review' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                \Filament\Infolists\Components\TextEntry::make('permit_number')
                    ->label('Permit Number')
                    ->copyable()
                    ->color('primary'),

                // 🚗 Test info
                \Filament\Infolists\Components\TextEntry::make('testCenter.city')
                    ->label('Test Center')
                    ->icon('heroicon-o-building-office'),

                \Filament\Infolists\Components\TextEntry::make('test_date')
                    ->label('Test Date')
                    ->date()
                    ->icon('heroicon-o-calendar-days'),

                \Filament\Infolists\Components\TextEntry::make('test_time')
                    ->label('Test Time')
                    ->time()
                    ->icon('heroicon-o-clock'),

                \Filament\Infolists\Components\TextEntry::make('b_status')
                    ->label('Booking Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ]),
        ]);
    }
}
