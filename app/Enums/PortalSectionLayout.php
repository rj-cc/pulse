<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PortalSectionLayout: string implements HasColor, HasLabel
{
    case Carousel = 'carousel';
    case IconGrid = 'icon_grid';
    case InfoGrid = 'info_grid';

    public function getLabel(): string
    {
        return match ($this) {
            self::Carousel => 'Carousel',
            self::IconGrid => 'Icon grid',
            self::InfoGrid => 'Info grid',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Carousel => 'info',
            self::IconGrid => 'success',
            self::InfoGrid => 'danger',
        };
    }
}
