<?php

namespace Database\Factories;

use App\Models\SidebarSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SidebarSection>
 */
class SidebarSectionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'icon' => 'bolt',
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
