<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Applications\Pages\ViewApplication;
use App\Filament\Resources\Applications\Pages\EditApplication;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('App ID')
                ->sortable()
                ->copyable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('user.full_name')
                ->label('Applicant')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('application_type')
                ->label('Type')
                ->sortable(),

            Tables\Columns\TextColumn::make('requested_license_type')
                ->label('License Type')
                ->sortable(),

            Tables\Columns\BadgeColumn::make('app_status')
                ->label('Status')
                // ->colors([
                //     'gray' => 'draft',
                //     'info' => 'under_review',
                //     'warning' => 'payment_pending',
                //     'success' => 'approved',
                //     'danger' => 'rejected',
                // ])
                ->sortable(),

            Tables\Columns\TextColumn::make('submitted_at')
                ->label('Submitted At')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated')
                ->dateTime()
                ->since(),

            // ✅ Custom "Actions" column (manual buttons)
           Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = ViewApplication::getUrl(['record' => $record]);
                        $editUrl = EditApplication::getUrl(['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="' . $viewUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-primary">View</a>
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                                <a href="' . $editUrl . '"
                                onclick="return confirm(\'Delete this user? You will be taken to the delete action on the edit page.\')"
                                class="fi-btn fi-btn-size-xs fi-btn-color-danger">
                                Delete
                                </a>
                            </div>
                        ';
                    })
        ])
        ->recordAction(null) // disables default row click
        ->bulkActions([]);

    }
}
