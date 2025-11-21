<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteAction;
class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    \Filament\Infolists\Components\TextEntry::make('full_name')
                        ->label('Full Name')
                        ->icon('heroicon-o-user')
                        ->weight('bold')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    \Filament\Infolists\Components\TextEntry::make('gender')
                        ->label('Gender')
                        ->icon('heroicon-o-identification')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),
                        
                    \Filament\Infolists\Components\TextEntry::make('email')
                        ->label('Email')
                        ->icon('heroicon-o-envelope')
                        ->copyable()
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    \Filament\Infolists\Components\TextEntry::make('phone')
                        ->label('Phone')
                        ->icon('heroicon-o-phone')
                        ->copyable()
                        ->color('info')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    \Filament\Infolists\Components\TextEntry::make('preferred_language')
                        ->label('Language')
                        ->icon('heroicon-o-globe-alt')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    \Filament\Infolists\Components\TextEntry::make('is_active')
                        ->label('Active')
                        ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                        ->badge()
                        ->color(fn ($state) => $state ? 'success' : 'danger')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),

                    \Filament\Infolists\Components\TextEntry::make('last_login_at')
                        ->label('Last Login')
                        ->dateTime()
                        ->icon('heroicon-o-clock')
                        ->extraAttributes([
                            'class' => 'border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-50 dark:bg-gray-900/40',
                        ]),
                ]),
            ]);
    }
}
