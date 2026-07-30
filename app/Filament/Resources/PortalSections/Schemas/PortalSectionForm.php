<?php

namespace App\Filament\Resources\PortalSections\Schemas;

use App\Enums\PortalSectionLayout;
use App\Filament\Schemas\PublishingSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PortalSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::detailsSection(),
                self::viewAllSection(),
                PublishingSection::make(),
            ]);
    }

    private static function detailsSection(): Section
    {
        return Section::make('Details')
            ->description('Section title and layout type shown on the portal.')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('layout')
                    ->options(PortalSectionLayout::class)
                    ->required()
                    ->native(false)
                    ->live(),
            ])
            ->compact()
            ->columns(2)
            ->columnSpanFull();
    }

    private static function viewAllSection(): Section
    {
        return Section::make('Show more toggle')
            ->description('Optional button to expand or collapse extra items on the portal page.')
            ->schema([
                TextInput::make('view_all_label')
                    ->label('Expand label')
                    ->maxLength(255)
                    ->helperText('Button text when items are collapsed.'),
                TextInput::make('initial_items_count')
                    ->label('Initial items shown')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Items beyond this count are hidden until expanded.')
                    ->required(fn (Get $get): bool => filled($get('view_all_label'))),
                TextInput::make('collapse_label')
                    ->label('Collapse label')
                    ->maxLength(255)
                    ->helperText('Button text when expanded. Defaults to "Show less" if empty.'),
            ])
            ->compact()
            ->columns(3)
            ->columnSpanFull()
            ->visible(fn (Get $get): bool => $get->enum(
                'layout',
                PortalSectionLayout::class,
                isNullable: true,
            ) !== PortalSectionLayout::Carousel);
    }
}
