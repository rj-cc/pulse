<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PortalColorPalette: string implements HasLabel
{
    case NavyGold = 'navy_gold';
    case InstitutionalBlue = 'institutional_blue';
    case ForestIvory = 'forest_ivory';
    case BurgundyCream = 'burgundy_cream';
    case CharcoalAmber = 'charcoal_amber';

    public function getLabel(): string
    {
        return match ($this) {
            self::NavyGold => 'Navy & Gold',
            self::InstitutionalBlue => 'Blue & Silver',
            self::ForestIvory => 'Forest & Ivory',
            self::BurgundyCream => 'Burgundy & Cream',
            self::CharcoalAmber => 'Charcoal & Amber',
        };
    }

    /**
     * @return array<string, string>
     */
    public function cssVariables(): array
    {
        return match ($this) {
            self::NavyGold => self::palette(
                primary: '#0b2a5b',
                primaryHover: '#143a75',
                brandAccent: '#f2c14e',
                background: '#f4f7fb',
                secondary: '#e8eef6',
                border: '#d8e0ec',
                mutedForeground: '#718096',
                shadowRgb: '11, 42, 91',
            ),
            self::InstitutionalBlue => self::palette(
                primary: '#003875',
                primaryHover: '#1a4f8c',
                brandAccent: '#94a3b8',
                background: '#f0f4f8',
                secondary: '#e2e8f0',
                border: '#cbd5e1',
                mutedForeground: '#718096',
                shadowRgb: '0, 56, 117',
            ),
            self::ForestIvory => self::palette(
                primary: '#1b4332',
                primaryHover: '#2d6a4f',
                brandAccent: '#b8860b',
                background: '#faf8f5',
                secondary: '#eef2ea',
                border: '#d4ddd0',
                mutedForeground: '#718096',
                shadowRgb: '27, 67, 50',
            ),
            self::BurgundyCream => self::palette(
                primary: '#6b2737',
                primaryHover: '#8b3347',
                brandAccent: '#c5a572',
                background: '#faf7f2',
                secondary: '#f0ebe3',
                border: '#ddd4c8',
                mutedForeground: '#718096',
                shadowRgb: '107, 39, 55',
            ),
            self::CharcoalAmber => self::palette(
                primary: '#2d3748',
                primaryHover: '#4a5568',
                brandAccent: '#d97706',
                background: '#f7fafc',
                secondary: '#edf2f7',
                border: '#cbd5e0',
                mutedForeground: '#718096',
                shadowRgb: '45, 55, 72',
            ),
        };
    }

    /**
     * BlatUI-compatible design tokens plus a portal brand accent for hairlines / highlights.
     *
     * @return array<string, string>
     */
    private static function palette(
        string $primary,
        string $primaryHover,
        string $brandAccent,
        string $background,
        string $secondary,
        string $border,
        string $mutedForeground,
        string $shadowRgb,
    ): array {
        return [
            '--background' => $background,
            '--foreground' => '#1a1a1a',
            '--card' => '#ffffff',
            '--card-foreground' => '#1a1a1a',
            '--popover' => '#ffffff',
            '--popover-foreground' => '#1a1a1a',
            '--primary' => $primary,
            '--primary-foreground' => '#ffffff',
            '--secondary' => $secondary,
            '--secondary-foreground' => $primary,
            '--muted' => $secondary,
            '--muted-foreground' => $mutedForeground,
            '--accent' => $secondary,
            '--accent-foreground' => $primary,
            '--destructive' => '#c8102e',
            '--destructive-foreground' => '#ffffff',
            '--border' => $border,
            '--input' => $border,
            '--ring' => $primaryHover,
            '--sidebar' => '#ffffff',
            '--sidebar-foreground' => '#1a1a1a',
            '--sidebar-primary' => $primary,
            '--sidebar-primary-foreground' => '#ffffff',
            '--sidebar-accent' => $secondary,
            '--sidebar-accent-foreground' => $primary,
            '--sidebar-border' => $border,
            '--sidebar-ring' => $primaryHover,
            '--brand-accent' => $brandAccent,
            '--shadow-sm' => "0 1px 2px rgba({$shadowRgb}, 0.04)",
            '--shadow' => "0 1px 3px rgba({$shadowRgb}, 0.06)",
            '--shadow-md' => "0 4px 12px rgba({$shadowRgb}, 0.08)",
            '--shadow-lg' => "0 10px 28px rgba({$shadowRgb}, 0.1)",
        ];
    }
}
