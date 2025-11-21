<?php

namespace App\Filament\Resources\Licenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;

class LicenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([

                    // Only visible to admin users
                    \Filament\Infolists\Components\TextEntry::make('user.full_name')
                        ->label('Holder')
                        ->visible(fn () => auth()->user()?->hasRole('admin') === true),

                    \Filament\Infolists\Components\TextEntry::make('license_number')
                        ->label('License #'),

                    \Filament\Infolists\Components\TextEntry::make('license_type')
                        ->label('Type')
                        ->badge(),

                    \Filament\Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn (string $state) => match ($state) {
                            'active' => 'success',
                            'expired' => 'danger',
                            'suspended' => 'warning',
                            default => 'secondary',
                        }),

                    \Filament\Infolists\Components\TextEntry::make('issued_at')
                        ->label('Issued At')
                        ->date()
                        ->placeholder('Not issued yet'),

                    \Filament\Infolists\Components\TextEntry::make('expires_at')
                        ->label('Expires At')
                        ->date()
                        ->placeholder('Not set'),

                    \Filament\Infolists\Components\TextEntry::make('created_at')
                        ->label('Created')
                        ->dateTime()
                        ->since(),

                    \Filament\Infolists\Components\TextEntry::make('updated_at')
                        ->label('Updated')
                        ->dateTime()
                        ->since(),
                ]),
            ]);
    }
}
