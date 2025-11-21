<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Pages\EditUser;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('preferred_language')
                    ->label('Lang')
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('Last Login')
                    ->dateTime()
                    ->sortable(),

            Tables\Columns\TextColumn::make('roles.name')
                ->label('Roles')
                ->badge()
                ->formatStateUsing(fn ($state, $record) => 
                    $record->roles->pluck('name')->implode(', ')
                )
                ->sortable(),


                Tables\Columns\TextColumn::make('actions')
                    ->label('Actions')
                    ->html()
                    ->getStateUsing(function ($record) {
                        $viewUrl = ViewUser::getUrl(['record' => $record]);
                        $editUrl = EditUser::getUrl(['record' => $record]);

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
                    ->extraAttributes(['class' => 'whitespace-nowrap'])
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Users')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
            ])
            ->recordAction(null) // disable default click behavior
            ->bulkActions([]);
    }
}
