<?php

namespace Database\Factories;

use App\Models\PortalSection;
use App\Models\PortalSectionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalSectionItem>
 */
class PortalSectionItemFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portal_section_id' => PortalSection::factory(),
            'title' => fake()->sentence(6),
            'subtitle' => fake()->sentence(4),
            'body' => fake()->paragraphs(3, true),
            'image_path' => null,
            'icon' => 'ti ti-file',
            'url' => null,
            'badges' => [['label' => 'New', 'style' => 'new']],
            'tag_label' => 'Memo',
            'tag_style' => 'memo',
            'meta_text' => fake()->sentence(3),
            'accent_color' => '#0B2A5B',
            'avatar_text' => null,
            'opens_modal' => true,
            'is_featured' => false,
            'published_at' => now(),
            'starts_at' => null,
            'ends_at' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
