<?php

namespace App\Filament\Resources\PortalSections\RelationManagers;

use App\Enums\PortalSectionLayout;
use App\Filament\Resources\PortalSections\Schemas\PortalSectionItemForm;
use App\Models\PortalSection;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items';

    public function form(Schema $schema): Schema
    {
        return PortalSectionItemForm::configure(
            $schema,
            fn (array $layouts): bool => $this->layoutIs($layouts),
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('meta_text')
                    ->toggleable(),
                IconColumn::make('opens_modal')
                    ->boolean()
                    ->label('Modal'),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                CreateAction::make()
                    ->label('New Item'),
            ])
            ->recordActions([
                EditAction::make()
                    ->hiddenLabel(),
                DeleteAction::make()
                    ->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @param  array<int, PortalSectionLayout>  $layouts
     */
    protected function layoutIs(array $layouts): bool
    {
        $owner = $this->getOwnerRecord();

        if (! $owner instanceof PortalSection) {
            return false;
        }

        return in_array($owner->layout, $layouts, true);
    }
}
