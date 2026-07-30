<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PortalFontStyle: string implements HasLabel
{
    case LexendSpaceGrotesk = 'lexend_space_grotesk';
    case ManropeFraunces = 'manrope_fraunces';
    case InterSourceSerif = 'inter_source_serif';
    case SourceSansSourceSerif = 'source_sans_source_serif';
    case JakartaLora = 'jakarta_lora';
    case DmSansMerriweather = 'dm_sans_merriweather';
    case MulishSourceSerif = 'mulish_source_serif';

    public function getLabel(): string
    {
        return match ($this) {
            self::LexendSpaceGrotesk => 'Lexend and Space Grotesk',
            self::ManropeFraunces => 'Manrope and Fraunces',
            self::InterSourceSerif => 'Inter and Source Serif',
            self::SourceSansSourceSerif => 'Source Sans and Source Serif',
            self::JakartaLora => 'Jakarta and Lora',
            self::DmSansMerriweather => 'DM Sans and Merriweather',
            self::MulishSourceSerif => 'Mulish and Source Serif',
        };
    }

    public function bodyFontFamily(): string
    {
        return match ($this) {
            self::LexendSpaceGrotesk => "'Lexend', ui-sans-serif, system-ui, sans-serif",
            self::ManropeFraunces => "'Manrope', ui-sans-serif, system-ui, sans-serif",
            self::InterSourceSerif => "'Inter', ui-sans-serif, system-ui, sans-serif",
            self::SourceSansSourceSerif => "'Source Sans 3', ui-sans-serif, system-ui, sans-serif",
            self::JakartaLora => "'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif",
            self::DmSansMerriweather => "'DM Sans', ui-sans-serif, system-ui, sans-serif",
            self::MulishSourceSerif => "'Mulish', ui-sans-serif, system-ui, sans-serif",
        };
    }

    public function headingFontFamily(): string
    {
        return match ($this) {
            self::LexendSpaceGrotesk => "'Space Grotesk', ui-sans-serif, system-ui, sans-serif",
            self::ManropeFraunces => "'Fraunces', Georgia, serif",
            self::InterSourceSerif => "'Source Serif 4', ui-serif, Georgia, serif",
            self::SourceSansSourceSerif => "'Source Serif 4', ui-serif, Georgia, serif",
            self::JakartaLora => "'Lora', ui-serif, Georgia, serif",
            self::DmSansMerriweather => "'Merriweather', ui-serif, Georgia, serif",
            self::MulishSourceSerif => "'Source Serif 4', ui-serif, Georgia, serif",
        };
    }

    /**
     * @return list<string>
     */
    public function fontAliases(): array
    {
        return match ($this) {
            self::LexendSpaceGrotesk => ['lexend', 'space-grotesk'],
            self::ManropeFraunces => ['manrope', 'fraunces'],
            self::InterSourceSerif => ['inter', 'source-serif-4'],
            self::SourceSansSourceSerif => ['source-sans-3', 'source-serif-4'],
            self::JakartaLora => ['plus-jakarta-sans', 'lora'],
            self::DmSansMerriweather => ['dm-sans', 'merriweather'],
            self::MulishSourceSerif => ['mulish', 'source-serif-4'],
        };
    }

    /**
     * @return list<string>
     */
    public function requiredFonts(): array
    {
        return $this->fontAliases();
    }

    /**
     * @return array<string, string>
     */
    public function cssVariables(): array
    {
        return [
            '--font-sans' => $this->bodyFontFamily(),
            '--font-heading' => $this->headingFontFamily(),
        ];
    }
}
