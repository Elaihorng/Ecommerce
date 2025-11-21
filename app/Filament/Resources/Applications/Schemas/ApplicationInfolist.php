<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class ApplicationInfolist
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

                    // 🪪 Application Type
                    \Filament\Infolists\Components\TextEntry::make('application_type')
                        ->label('Type')
                        ->badge()
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🚗 License Type
                    \Filament\Infolists\Components\TextEntry::make('requested_license_type')
                        ->label('License Type')
                        ->icon('heroicon-o-identification')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📊 Status
                    \Filament\Infolists\Components\TextEntry::make('app_status')
                        ->label('Status')
                        ->badge()
                        ->icon('heroicon-o-check-circle')
                        // ->color(fn (string $state) => match ($state) {
                        //     'approved' => 'success',
                        //     'rejected' => 'danger',
                        //     'under_review' => 'warning',
                        //     'payment_pending' => 'info',
                        //     'issued' => 'success',
                        //     'expired' => 'gray',
                        //     default => 'under_review',
                        // })
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 📝 Notes
                    \Filament\Infolists\Components\TextEntry::make('notes')
                        ->label('Notes')
                        ->icon('heroicon-o-clipboard-document')
                        ->default('No notes.')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    // 🕓 Submitted At
                    \Filament\Infolists\Components\TextEntry::make('submitted_at')
                        ->label('Submitted')
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
