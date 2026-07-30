<?php

namespace Database\Factories;

use App\Enums\PortalSectionLayout;
use App\Models\PortalSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortalSection>
 */
class PortalSectionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'layout' => fake()->randomElement(PortalSectionLayout::cases()),
            'view_all_label' => 'View all',
            'initial_items_count' => 4,
            'collapse_label' => 'Show less',
            'is_published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    public function carousel(): static
    {
        return $this->state(fn (): array => [
            'layout' => PortalSectionLayout::Carousel,
        ]);
    }

    public function iconGrid(): static
    {
        return $this->state(fn (): array => [
            'layout' => PortalSectionLayout::IconGrid,
        ]);
    }

    public function infoGrid(): static
    {
        return $this->state(fn (): array => [
            'layout' => PortalSectionLayout::InfoGrid,
        ]);
    }
}
