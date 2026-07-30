<?php

namespace App\Filament\Resources\SidebarSections\Pages;

use App\Filament\Resources\SidebarSections\SidebarSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSidebarSections extends ListRecords
{
    protected static string $resource = SidebarSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Sidebar Section'),
        ];
    }
}
