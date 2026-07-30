<?php

namespace App\Models;

use App\Enums\PortalColorPalette;
use App\Enums\PortalFontStyle;
use Database\Factories\PortalSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'organization_name',
    'organization_tagline',
    'logo_path',
    'topbar_phone',
    'topbar_email',
    'topbar_right_label',
    'hero_subtitle',
    'hero_motto',
    'footer_motto',
    'footer_copyright',
    'footer_right_label',
    'footer_links',
    'color_palette',
    'font_style',
    'updated_by',
])]
class PortalSetting extends Model
{
    /** @use HasFactory<PortalSettingFactory> */
    use HasFactory;

    protected static ?self $cached = null;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'footer_links' => 'array',
            'color_palette' => PortalColorPalette::class,
            'font_style' => PortalFontStyle::class,
        ];
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function current(): self
    {
        return static::$cached ??= static::query()->firstOrCreate(
            [],
            [
                'organization_name' => 'Employee Portal',
                'organization_tagline' => null,
                'footer_links' => [],
                'color_palette' => PortalColorPalette::NavyGold,
                'font_style' => PortalFontStyle::ManropeFraunces,
            ]
        );
    }

    public function appearanceStyle(): string
    {
        $palette = $this->color_palette ?? PortalColorPalette::NavyGold;
        $fontStyle = $this->font_style ?? PortalFontStyle::ManropeFraunces;

        $variables = array_merge(
            $palette->cssVariables(),
            $fontStyle->cssVariables(),
            ['--radius' => '0.5rem'],
        );

        return collect($variables)
            ->map(fn (string $value, string $key): string => "{$key}: {$value}")
            ->implode('; ');
    }

    public function logoUrl(): ?string
    {
        if (blank($this->logo_path)) {
            return null;
        }

        return Storage::disk('public')->url($this->logo_path);
    }
}
