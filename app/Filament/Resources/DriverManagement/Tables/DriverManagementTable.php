<?php

namespace App\Filament\Resources\DriverManagement\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\DriverManagement\Pages\ViewDriverManagement;
use App\Filament\Resources\DriverManagement\Pages\EditDriverManagement;

class DriverManagementTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Booking ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),

                // Tables\Columns\TextColumn::make('user.gender')
                //     ->label('Gender'),

                // Tables\Columns\TextColumn::make('user.dob')
                //     ->label('Date of Birth')
                //     ->date(),

                // Tables\Columns\TextColumn::make('user.phone')
                //     ->label('Phone'),

                // Tables\Columns\TextColumn::make('user.email')
                //     ->label('Email'),

                Tables\Columns\TextColumn::make('application.requested_license_type')
                    ->label('License Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('application.application_type')
                    ->label('Application Type'),

                // Tables\Columns\TextColumn::make('permit_number')
                //     ->label('Permit Number'),

                // Tables\Columns\TextColumn::make('test_date')
                //     ->label('Test Date')
                //     ->date(),

                Tables\Columns\TextColumn::make('testCenter.city')
                    ->label('Test Center'),

                Tables\Columns\BadgeColumn::make('application.app_status')
                    ->label('Application Status'),
                    
                Tables\Columns\BadgeColumn::make('b_status')
                    ->label('Booking Status')
                    ->colors([
                        'gray' => 'pending',
                        'warning' => 'under_review',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),

                

                

                // Tables\Columns\TextColumn::make('user.nationalIdCard.khmer_id')
                //     ->label('Khmer ID'),

                // 👇 Custom Action Buttons (like in UsersTable)
                Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = route('filament.admin.resources.driver-management.view', ['record' => $record]);
                        $editUrl = route('filament.admin.resources.driver-management.edit', ['record' => $record]);

                        return '
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <a href="' . $viewUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-primary">View</a>
                                <a href="' . $editUrl . '" class="fi-btn fi-btn-size-xs fi-btn-color-warning">Edit</a>
                            </div>
                        ';
                    }),
            ])
            ->filters([])
            ->recordAction(null)
            ->bulkActions([]);
    }
}
