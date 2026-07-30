<?php

namespace App\Filament\Resources\PortalSections\Tables;

use App\Enums\PortalSectionLayout;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PortalSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('layout')
                    ->badge()
                    ->color(fn (PortalSectionLayout $state): string|array|null => $state->getColor()),
                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Item Count'),
                ToggleColumn::make('is_published')
                    ->label('Published'),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make()
                    ->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
