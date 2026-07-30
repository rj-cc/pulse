<?php

namespace Database\Factories;

use App\Enums\PortalColorPalette;
use App\Enums\PortalFontStyle;
use App\Models\PortalSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalSetting>
 */
class PortalSettingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_name' => fake()->company(),
            'organization_tagline' => fake()->sentence(4),
            'logo_path' => null,
            'topbar_phone' => fake()->phoneNumber(),
            'topbar_email' => fake()->companyEmail(),
            'topbar_right_label' => fake()->country(),
            'hero_subtitle' => fake()->paragraph(),
            'hero_motto' => fake()->sentence(6),
            'footer_motto' => fake()->sentence(6),
            'footer_copyright' => '© '.now()->year.' '.fake()->company(),
            'footer_right_label' => fake()->country(),
            'footer_links' => [
                ['label' => 'About', 'url' => '#'],
                ['label' => 'Privacy', 'url' => '#'],
            ],
            'color_palette' => PortalColorPalette::NavyGold,
            'font_style' => PortalFontStyle::ManropeFraunces,
        ];
    }
}
