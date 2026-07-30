<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class PublishingSection
{
    public static function make(
        bool $includeSchedule = false,
        ?string $description = null,
    ): Section {
        $schema = [
            Toggle::make('is_published')
                ->label('Published')
                ->default(true),
            TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ->required(),
        ];

        if ($includeSchedule) {
            $schema = array_merge($schema, [
                DateTimePicker::make('published_at')
                    ->default(fn () => now())
                    ->disabledOn('edit'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
            ]);
        }

        return Section::make('Publishing')
            ->description($description ?? ($includeSchedule
                ? 'Control visibility, schedule, and list order.'
                : 'Control visibility and list order.'))
            ->schema($schema)
            ->columns(2)
            ->compact()
            ->collapsible()
            ->collapsed()
            ->columnSpanFull();
    }
}
