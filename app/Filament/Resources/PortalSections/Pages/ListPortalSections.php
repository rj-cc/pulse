<?php

namespace App\Filament\Resources\PortalSections\Pages;

use App\Filament\Resources\PortalSections\PortalSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortalSections extends ListRecords
{
    protected static string $resource = PortalSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Main Section'),
        ];
    }
}
