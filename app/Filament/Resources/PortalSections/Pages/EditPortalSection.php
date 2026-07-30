<?php

namespace App\Filament\Resources\PortalSections\Pages;

use App\Filament\Resources\PortalSections\PortalSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPortalSection extends EditRecord
{
    protected static string $resource = PortalSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
