<?php

namespace App\Filament\Resources\TestResults\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\TestResults\Pages\ViewTestResult;
use App\Filament\Resources\TestResults\Pages\EditTestResult;

class TestResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 🧾 Booking
                TextColumn::make('booking.id')
                    ->label('Booking ID')
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 👤 Driver Name
                TextColumn::make('user.full_name')
                    ->label('Driver')
                    ->searchable()
                    ->sortable(),

                // 📘 Theory Result
                BadgeColumn::make('theory_result')
                    ->label('Theory Test')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'pass',
                        'danger' => 'fail',
                    ])
                    ->sortable(),

                // 🚗 Practical Result
                BadgeColumn::make('practical_result')
                    ->label('Practical Test')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'pass',
                        'danger' => 'fail',
                    ])
                    ->sortable(),

                // 🕒 Tested Date
                TextColumn::make('tested_at')
                    ->label('Tested At')
                    ->dateTime()
                    ->sortable(),

                // 🧠 Remarks
                TextColumn::make('remarks')
                    ->label('Remarks')
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 🛠 Actions column like ApplicationsTable
                TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = ViewTestResult::getUrl(['record' => $record]);
                        $editUrl = EditTestResult::getUrl(['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="' . $viewUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-primary">View</a>
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                                <a href="' . $editUrl . '"
                                    onclick="return confirm(\'Delete this record? You will be taken to the delete action on the edit page.\')"
                                    class="fi-btn fi-btn-size-xs fi-btn-color-danger">
                                    Delete
                                </a>
                            </div>
                        ';
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('theory_result')
                    ->label('Theory Result')
                    ->options([
                        'pending' => 'Pending',
                        'pass' => 'Pass',
                        'fail' => 'Fail',
                    ]),
                Tables\Filters\SelectFilter::make('practical_result')
                    ->label('Practical Result')
                    ->options([
                        'pending' => 'Pending',
                        'pass' => 'Pass',
                        'fail' => 'Fail',
                    ]),
            ])
            ->recordAction(null) // disables default row click
            ->bulkActions([]); // disable default bulk actions
    }
}
