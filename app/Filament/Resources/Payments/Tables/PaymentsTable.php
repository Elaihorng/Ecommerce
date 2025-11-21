<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Payments\Pages\ViewPayment;
use App\Filament\Resources\Payments\Pages\EditPayment;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Payment ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('application.id')
                    ->label('Application ID')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('application.permit_number')
                    ->label('Permit Number')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('KHR', divideBy: 1),

                Tables\Columns\TextColumn::make('provider')
                    ->label('Provider')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('p_status')
                    ->label('Status')
                    ->colors([
                        'info' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'warning' => 'refunded',
                    ])
                    ->sortable(),

                // Tables\Columns\TextColumn::make('paid_at')
                //     ->label('Paid At')
                //     ->dateTime()
                //     ->sortable(),

                // Custom actions column (renders HTML buttons)
                Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = ViewPayment::getUrl(['record' => $record]);
                        $editUrl = EditPayment::getUrl(['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="' . $viewUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-primary">View</a>
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                                <a href="' . $editUrl . '"
                                   onclick="return confirm(\'Delete this payment? You will be taken to the delete action on the edit page.\')"
                                   class="fi-btn fi-btn-size-xs fi-btn-color-danger">
                                    Delete
                                </a>
                            </div>
                        ';
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'paid'     => 'Paid',
                        'failed'   => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->recordAction(null) // disable default row click
            ->bulkActions([]);    // no bulk actions
    }
}
