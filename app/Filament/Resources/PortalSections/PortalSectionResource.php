<?php

namespace App\Filament\Resources\PortalSections;

use App\Filament\Resources\PortalSections\Pages\CreatePortalSection;
use App\Filament\Resources\PortalSections\Pages\EditPortalSection;
use App\Filament\Resources\PortalSections\Pages\ListPortalSections;
use App\Filament\Resources\PortalSections\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\PortalSections\Schemas\PortalSectionForm;
use App\Filament\Resources\PortalSections\Tables\PortalSectionsTable;
use App\Models\PortalSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PortalSectionResource extends Resource
{
    protected static ?string $model = PortalSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Portal';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Main Sections';

    protected static ?string $modelLabel = 'main section';

    protected static ?string $pluralModelLabel = 'main sections';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PortalSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortalSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortalSections::route('/'),
            'create' => CreatePortalSection::route('/create'),
            'edit' => EditPortalSection::route('/{record}/edit'),
        ];
    }
}
