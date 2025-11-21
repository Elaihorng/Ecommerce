<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([

                    // 👤 Payer (only visible to admin)
                    \Filament\Infolists\Components\TextEntry::make('user.full_name')
                        ->label('User')
                        ->icon('heroicon-o-user')
                        ->visible(fn () => auth()->user()?->hasRole('admin') === true)
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🆔 Payment ID
                    \Filament\Infolists\Components\TextEntry::make('id')
                        ->label('Payment ID')
                        ->icon('heroicon-o-identification')
                        ->copyable()
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🪪 Application ID
                    \Filament\Infolists\Components\TextEntry::make('application_id')
                        ->label('Application ID')
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 💰 Amount
                    \Filament\Infolists\Components\TextEntry::make('amount')
                        ->label('Amount (KHR)')
                        ->icon('heroicon-o-currency-dollar')
                        ->formatStateUsing(fn ($state) => number_format($state, 0) . '៛')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 💳 Provider
                    \Filament\Infolists\Components\TextEntry::make('provider')
                        ->label('Provider')
                        ->icon('heroicon-o-credit-card')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🔢 Provider Payment ID
                    \Filament\Infolists\Components\TextEntry::make('provider_payment_id')
                        ->label('Provider Payment ID')
                        ->icon('heroicon-o-hashtag')
                        ->copyable()
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📊 Status
                    \Filament\Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->icon('heroicon-o-check-circle')
                        ->color(fn (string $state) => match ($state) {
                            'paid' => 'success',
                            'pending' => 'info',
                            'failed' => 'danger',
                            'refunded' => 'warning',
                            default => 'gray',
                        })
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // // 🕓 Paid Date
                    // \Filament\Infolists\Components\TextEntry::make('paid_at')
                    //     ->label('Paid Date')
                    //     ->dateTime()
                    //     ->icon('heroicon-o-calendar-days')
                    //     ->default('pending')
                    //     ->extraAttributes([
                    //         'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                    //     ]),

                    // 🕒 Created
                    \Filament\Infolists\Components\TextEntry::make('created_at')
                        ->label('Created')
                        ->dateTime()
                        ->icon('heroicon-o-clock')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🕓 Updated
                    \Filament\Infolists\Components\TextEntry::make('updated_at')
                        ->label('Updated')
                        ->dateTime()
                        ->icon('heroicon-o-arrow-path')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),
                ]),
            ]);
    }
}
