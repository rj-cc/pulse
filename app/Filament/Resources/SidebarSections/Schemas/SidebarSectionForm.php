<?php

namespace App\Filament\Resources\SidebarSections\Schemas;

use App\Filament\Schemas\PublishingSection;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SidebarSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::detailsSection(),
                PublishingSection::make(),
            ]);
    }

    private static function detailsSection(): Section
    {
        return Section::make('Details')
            ->description('Tab label and icon shown in the portal sidebar.')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('icon')
                    ->helperText('Use Lucide icon names. Search for icons at https://lucide.dev/icons/')
                    ->maxLength(50),
            ])
            ->compact()
            ->columns(2)
            ->columnSpanFull();
    }
}
