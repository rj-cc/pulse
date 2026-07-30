<?php

namespace Database\Factories;

use App\Models\SidebarItem;
use App\Models\SidebarSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SidebarItem>
 */
class SidebarItemFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sidebar_section_id' => SidebarSection::factory(),
            'title' => fake()->words(2, true),
            'subtitle' => fake()->sentence(3),
            'icon' => 'link',
            'url' => '#',
            'avatar_text' => null,
            'image_path' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
