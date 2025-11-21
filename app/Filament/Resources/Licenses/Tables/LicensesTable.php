<?php

namespace App\Filament\Resources\Licenses\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Licenses\Pages\ViewLicense;
use App\Filament\Resources\Licenses\Pages\EditLicense;

class LicensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Holder')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('license_number')
                    ->label('License #')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('license_type')
                    ->label('Type')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'expired',
                        'warning' => 'suspended',
                        'gray' => fn ($state) => ! in_array($state, ['active','expired','suspended']),
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('issued_at')
                    ->label('Issued At')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires At')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since(),

                // Manual actions column (matches your Applications table style)
                Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = ViewLicense::getUrl(['record' => $record]);
                        $editUrl = EditLicense::getUrl(['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="' . $viewUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-primary">View</a>
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                                <a href="' . $editUrl . '"
                                   onclick="return confirm(\'Delete this license? You will be taken to the delete action on the edit page.\')"
                                   class="fi-btn fi-btn-size-xs fi-btn-color-danger">
                                   Delete
                                </a>
                            </div>
                        ';
                    }),
            ])
            ->recordAction(null) // disable default row click
            ->bulkActions([]);    // no bulk actions
    }
}
