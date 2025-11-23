<?php

namespace App\Filament\Resources\LicenseRenewals;

use App\Filament\Resources\LicenseRenewals\Pages\CreateLicenseRenewal;
use App\Filament\Resources\LicenseRenewals\Pages\EditLicenseRenewal;
use App\Filament\Resources\LicenseRenewals\Pages\ListLicenseRenewals;
use App\Filament\Resources\LicenseRenewals\Pages\ViewLicenseRenewal;
use App\Filament\Resources\LicenseRenewals\Schemas\LicenseRenewalForm;
use App\Filament\Resources\LicenseRenewals\Schemas\LicenseRenewalInfolist;
use App\Filament\Resources\LicenseRenewals\Tables\LicenseRenewalsTable;
use App\Models\LicenseRenewal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LicenseRenewalResource extends Resource
{
    protected static ?string $model = LicenseRenewal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'LicenseRenewal';

    public static function form(Schema $schema): Schema
    {
        return LicenseRenewalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LicenseRenewalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicenseRenewalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicenseRenewals::route('/'),
            'create' => CreateLicenseRenewal::route('/create'),
            'view' => ViewLicenseRenewal::route('/{record}'),
            'edit' => EditLicenseRenewal::route('/{record}/edit'),
        ];
    }
}
