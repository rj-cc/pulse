<?php

namespace App\Filament\Resources\PortalSections\Schemas;

use App\Enums\PortalSectionLayout;
use App\Filament\Schemas\PublishingSection;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PortalSectionItemForm
{
    /**
     * @param  Closure(array<int, PortalSectionLayout>): bool  $layoutIs
     */
    public static function configure(Schema $schema, Closure $layoutIs): Schema
    {
        return $schema
            ->components([
                self::contentSection($layoutIs),
                self::displaySection($layoutIs),
                self::behaviorSection($layoutIs),
                PublishingSection::make(includeSchedule: true),
            ]);
    }

    /**
     * @param  Closure(array<int, PortalSectionLayout>): bool  $layoutIs
     */
    private static function contentSection(Closure $layoutIs): Section
    {
        return Section::make('Content')
            ->description('Title and body shown on the card and in the detail sheet.')
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('subtitle')
                    ->rows(2)
                    ->columnSpanFull()
                    ->visible(fn (): bool => $layoutIs([PortalSectionLayout::IconGrid])),
                RichEditor::make('body')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike'],
                        ['h2', 'h3'],
                        ['alignStart', 'alignCenter', 'alignEnd'],
                        ['undo', 'redo'],
                    ])
                    ->columnSpanFull(),
            ])
            ->compact()
            ->columnSpanFull();
    }

    /**
     * @param  Closure(array<int, PortalSectionLayout>): bool  $layoutIs
     */
    private static function displaySection(Closure $layoutIs): Section
    {
        return Section::make('Card display')
            ->description('Visual options for the tile or slide. Available fields depend on the section layout.')
            ->schema([
                Fieldset::make('Image & accent')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('portal/items')
                            ->visibility('public')
                            ->visible(fn (): bool => $layoutIs([
                                PortalSectionLayout::Carousel,
                                PortalSectionLayout::InfoGrid,
                            ])),
                        ColorPicker::make('accent_color')
                            ->label('Accent color')
                            ->visible(fn (): bool => $layoutIs([
                                PortalSectionLayout::Carousel,
                                PortalSectionLayout::IconGrid,
                                PortalSectionLayout::InfoGrid,
                            ])),
                        TextInput::make('icon')
                            ->helperText('Tabler icon class, e.g. ti ti-file-invoice')
                            ->visible(fn (): bool => $layoutIs([PortalSectionLayout::IconGrid])),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Fieldset::make('Labels')
                    ->schema([
                        Repeater::make('badges')
                            ->table([
                                TableColumn::make('Label'),
                                TableColumn::make('Style'),
                            ])
                            ->schema([
                                TextInput::make('label')->required()->maxLength(50),
                                Select::make('style')
                                    ->options([
                                        'important' => 'Important',
                                        'new' => 'New',
                                        'event' => 'Event',
                                    ])
                                    ->required(),
                            ])
                            ->compact()
                            ->visible(fn (): bool => $layoutIs([PortalSectionLayout::Carousel]))
                            ->columnSpanFull(),
                        TextInput::make('tag_label')
                            ->visible(fn (): bool => $layoutIs([PortalSectionLayout::InfoGrid])),
                        Select::make('tag_style')
                            ->options([
                                'memo' => 'Memo',
                                'deadline' => 'Deadline',
                                'spotlight' => 'Spotlight',
                            ])
                            ->native(false)
                            ->visible(fn (): bool => $layoutIs([PortalSectionLayout::InfoGrid])),
                        TextInput::make('meta_text')
                            ->label('Meta text')
                            ->maxLength(255)
                            ->helperText('If left blank, it would display the time since it was published.')
                            ->visible(fn (): bool => $layoutIs([
                                PortalSectionLayout::Carousel,
                                PortalSectionLayout::InfoGrid,
                            ])),
                    ])
                    ->visible(fn (): bool => $layoutIs([
                        PortalSectionLayout::Carousel,
                        PortalSectionLayout::InfoGrid,
                    ]))
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->compact()
            ->columns(2)
            ->columnSpanFull();
    }

    /**
     * @param  Closure(array<int, PortalSectionLayout>): bool  $layoutIs
     */
    private static function behaviorSection(Closure $layoutIs): Section
    {
        return Section::make('Link & behavior')
            ->description('URL or detail sheet mode for this item.')
            ->schema([
                TextInput::make('url')
                    ->label('URL')
                    ->maxLength(255)
                    ->visible(function (Get $get): bool {
                        $opensModalValue = $get->boolean('opens_modal');
                        return !$opensModalValue;
                    })
                    ->live(onBlur: true),
                Toggle::make('opens_modal')
                    ->label('Open detail sheet')
                    ->helperText('When enabled, clicking opens the detail sheet with the body content above.')
                    ->default(true)
                    ->live()
                    ->visible(fn (Get $get): bool => !filled($get->string('url'))),
                Toggle::make('is_featured')
                    ->label('Featured / Highlight item')
                    ->visible(fn (): bool => $layoutIs([PortalSectionLayout::IconGrid])),
            ])
            ->compact()
            ->columns(2)
            ->columnSpanFull();
    }
}
