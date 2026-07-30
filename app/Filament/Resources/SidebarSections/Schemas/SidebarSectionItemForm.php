<?php

namespace App\Filament\Resources\SidebarSections\Schemas;

use App\Filament\Schemas\PublishingSection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SidebarSectionItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::contentSection(),
                self::displaySection(),
                self::linkSection(),
                PublishingSection::make(),
            ]);
    }

    private static function contentSection(): Section
    {
        return Section::make('Content')
            ->description('Title and subtitle shown in the sidebar panel.')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('subtitle')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])
            ->compact()
            ->columnSpanFull();
    }

    private static function displaySection(): Section
    {
        return Section::make('Display')
            ->description('Visual options for the sidebar item.')
            ->schema([
                Fieldset::make('Icon & avatar')
                    ->schema([
                        TextInput::make('icon')
                            ->helperText('Use Lucide icon names. Search for icons at https://lucide.dev/icons/')
                            ->maxLength(50),
                        TextInput::make('avatar_text')
                            ->label('Avatar initials')
                            ->maxLength(4),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Fieldset::make('Image')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('portal/sidebar')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->compact()
            ->columnSpanFull();
    }

    private static function linkSection(): Section
    {
        return Section::make('Link')
            ->schema([
                TextInput::make('url')
                    ->label('URL')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])
            ->compact()
            ->columnSpanFull();
    }
}
