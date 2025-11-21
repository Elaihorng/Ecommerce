<?php

namespace App\Filament\Resources\TestResults;

use App\Filament\Resources\TestResults\Pages\CreateTestResult;
use App\Filament\Resources\TestResults\Pages\EditTestResult;
use App\Filament\Resources\TestResults\Pages\ListTestResults;
use App\Filament\Resources\TestResults\Schemas\TestResultForm;
use App\Filament\Resources\TestResults\Tables\TestResultsTable;
use App\Models\TestResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestResultResource extends Resource
{
    protected static ?string $model = TestResult::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;
    protected static string | \UnitEnum | null $navigationGroup = 'Driver Management';

    protected static ?string $navigationLabel = 'Test Results';

    // ✅ Use Schema (not Form)
    public static function form(Schema $schema): Schema
    {
        return TestResultForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestResultsTable::configure($table);
    }

public static function getPages(): array
{
    return [
        'index'  => Pages\ListTestResults::route('/'),
        'create' => Pages\CreateTestResult::route('/create'),
        'view'   => Pages\ViewTestResult::route('/{record}'),
        'edit'   => Pages\EditTestResult::route('/{record}/edit'),
    ];
}
}
