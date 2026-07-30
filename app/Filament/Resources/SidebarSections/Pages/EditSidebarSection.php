<?php

namespace App\Filament\Resources\SidebarSections\Pages;

use App\Filament\Resources\SidebarSections\SidebarSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSidebarSection extends EditRecord
{
    protected static string $resource = SidebarSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
