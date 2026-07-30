<?php

use App\Enums\PortalColorPalette;
use App\Enums\PortalFontStyle;
use App\Models\PortalSetting;
use Illuminate\Support\Collection;

test('portal index view renders organization branding', function () {
    $settings = PortalSetting::factory()->make([
        'organization_name' => 'Agency Portal Demo',
        'organization_tagline' => 'Serving the public',
        'color_palette' => PortalColorPalette::NavyGold,
        'font_style' => PortalFontStyle::ManropeFraunces,
        'footer_links' => [],
        'footer_copyright' => '© Agency',
    ]);

    $this->withoutVite()->view('portal.index', [
        'settings' => $settings,
        'sections' => new Collection,
        'sidebarSections' => new Collection,
        'modalItems' => new Collection,
    ])
        ->assertSee('Agency Portal Demo', false)
        ->assertSee('Serving the public', false)
        ->assertSee('portal-detail', false)
        ->assertSee('--primary', false)
        ->assertSee('--brand-accent', false);
});

test('portal color palettes emit blatui tokens without legacy navy variables', function () {
    $variables = PortalColorPalette::NavyGold->cssVariables();

    expect($variables)
        ->toHaveKey('--primary')
        ->toHaveKey('--background')
        ->toHaveKey('--brand-accent')
        ->not->toHaveKey('--font-sans')
        ->not->toHaveKey('--navy')
        ->not->toHaveKey('--gold')
        ->not->toHaveKey('--surface')
        ->not->toHaveKey('--ink');
});
