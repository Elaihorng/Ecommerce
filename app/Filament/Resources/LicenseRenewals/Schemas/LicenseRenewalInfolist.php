<?php

namespace App\Filament\Resources\LicenseRenewals\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class LicenseRenewalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([

                    // 👤 Applicant (only for admins)
                    \Filament\Infolists\Components\TextEntry::make('user.full_name')
                        ->label('Applicant')
                        ->icon('heroicon-o-user')
                        ->visible(fn () => auth()->user()?->hasRole('admin') === true)
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🪪 Permit Number
                    \Filament\Infolists\Components\TextEntry::make('permit_number')
                        ->label('Permit Number')
                        ->badge()
                        ->icon('heroicon-o-identification')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🔢 Current License Number
                    \Filament\Infolists\Components\TextEntry::make('current_license_number')
                        ->label('Current License No.')
                        ->icon('heroicon-o-hashtag')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📎 Reference
                    \Filament\Infolists\Components\TextEntry::make('reference')
                        ->label('Reference')
                        ->icon('heroicon-o-link')
                        ->default('N/A')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🚚 Delivery Option
                    \Filament\Infolists\Components\TextEntry::make('delivery_option')
                        ->label('Delivery Option')
                        ->badge()
                        ->icon('heroicon-o-truck')
                        ->formatStateUsing(
                            fn (?string $state) => $state
                                ? ucfirst(str_replace('_', ' ', $state))
                                : 'N/A'
                        )
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📍 Delivery Address
                    \Filament\Infolists\Components\TextEntry::make('delivery_address')
                        ->label('Delivery Address')
                        ->icon('heroicon-o-map-pin')
                        ->default('No delivery address.')
                        ->columnSpanFull()
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📊 Status
                    \Filament\Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->icon('heroicon-o-check-circle')
                        // ->color(fn (string $state) => match ($state) {
                        //     'pending'   => 'warning',
                        //     'submitted' => 'info',
                        //     'paid'      => 'success',
                        //     'approved'  => 'success',
                        //     'rejected'  => 'danger',
                        //     default     => 'gray',
                        // })
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🕓 Created At
                    \Filament\Infolists\Components\TextEntry::make('created_at')
                        ->label('Created')
                        ->dateTime()
                        ->icon('heroicon-o-calendar-days')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🔁 Last Updated
                    \Filament\Infolists\Components\TextEntry::make('updated_at')
                        ->label('Updated')
                        ->dateTime()
                        ->icon('heroicon-o-clock')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),
                ]),
            ]);
    }
}
