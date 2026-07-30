<?php

namespace App\Filament\Resources\SidebarSections;

use App\Filament\Resources\SidebarSections\Pages\CreateSidebarSection;
use App\Filament\Resources\SidebarSections\Pages\EditSidebarSection;
use App\Filament\Resources\SidebarSections\Pages\ListSidebarSections;
use App\Filament\Resources\SidebarSections\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\SidebarSections\Schemas\SidebarSectionForm;
use App\Filament\Resources\SidebarSections\Tables\SidebarSectionsTable;
use App\Models\SidebarSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SidebarSectionResource extends Resource
{
    protected static ?string $model = SidebarSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3BottomLeft;

    protected static string|UnitEnum|null $navigationGroup = 'Portal';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Sidebar Sections';

    protected static ?string $modelLabel = 'sidebar section';

    protected static ?string $pluralModelLabel = 'sidebar sections';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SidebarSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SidebarSectionsTable::configure($table);
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
            'index' => ListSidebarSections::route('/'),
            'create' => CreateSidebarSection::route('/create'),
            'edit' => EditSidebarSection::route('/{record}/edit'),
        ];
    }
}
