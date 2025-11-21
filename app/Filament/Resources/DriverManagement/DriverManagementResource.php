<?php

namespace App\Filament\Resources\DriverManagement;

use App\Filament\Resources\DriverManagement\Pages\ListDriverManagement;
use App\Filament\Resources\DriverManagement\Pages\ViewDriverManagement;
use App\Filament\Resources\DriverManagement\Pages\EditDriverManagement;
use App\Filament\Resources\DriverManagement\Tables\DriverManagementTable;
use App\Filament\Resources\DriverManagement\Schemas\DriverManagementInfolist;
// ✅ Add these imports
use App\Filament\Resources\DriverManagement\Schemas\DriverManagementForm;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class DriverManagementResource extends Resource
{
    protected static ?string $model = Booking::class;

    // Sidebar menu group and label
    protected static string|\UnitEnum|null $navigationGroup = 'Driver Management';
    protected static ?string $navigationLabel = 'Bookings';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    public static function form(Schema $schema): Schema
    {
        return DriverManagementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        // Optional: for View page (Driver details)
        return DriverManagementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // Use external table configuration (same pattern as UserResource)
        return DriverManagementTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }
    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             Tables\Columns\TextColumn::make('user.full_name')->label('Full Name'),
    //             Tables\Columns\TextColumn::make('permit_number')->label('Permit Number'),
    //             Tables\Columns\TextColumn::make('test_date')->label('Test Date'),
    //             Tables\Columns\BadgeColumn::make('b_status')
    //                 ->label('Booking Status')
    //                 ->colors([
    //                     'gray' => 'pending',
    //                     'warning' => 'under_review',
    //                     'success' => 'approved',
    //                     'danger' => 'rejected',
    //                 ]),
    //         ])
    //         ->actions([
    //             TablesActions\ViewAction::make(),
    //             TablesActions\EditAction::make(),
    //         ]);
    // }
    public static function getPages(): array
    {
        return [
            'index' => ListDriverManagement::route('/'),
            'view' => ViewDriverManagement::route('/{record}'),
            'edit' => EditDriverManagement::route('/{record}/edit'),
        ];
    }
}
