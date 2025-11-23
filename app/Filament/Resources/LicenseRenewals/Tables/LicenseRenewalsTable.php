<?php

namespace App\Filament\Resources\LicenseRenewals\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
// use App\Filament\Resources\LicenseRenewals\Pages\ViewLicenseRenewal; // if you create a view page
use App\Filament\Resources\LicenseRenewals\Pages\EditLicenseRenewal;

class LicenseRenewalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Renewal ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('permit_number')
                    ->label('Permit Number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('current_license_number')
                    ->label('Current License No.')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reference')
                    ->label('Reference')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('delivery_option')
                    ->label('Delivery')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', (string) $state)))
                    ->colors([
                        'primary',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'submitted',
                        'success' => 'paid',
                        'primary' => 'approved',
                        'danger'  => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since(),

                // Custom actions column (manual buttons) – like ApplicationsTable
                Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        // if you have a View page later:
                        // $viewUrl = ViewLicenseRenewal::getUrl(['record' => $record]);
                        $editUrl = EditLicenseRenewal::getUrl(['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                               
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                                <a href="' . $editUrl . '"
                                    onclick="return confirm(\'Delete this renewal? You will be taken to the delete action on the edit page.\')"
                                    class="fi-btn fi-btn-size-xs fi-btn-color-danger">
                                    Delete
                                </a>
                            </div>
                        ';
                    }),
            ])
            ->recordAction(null) // disable default row click
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
