<?php

namespace App\Http\Controllers;

use App\Models\PortalSection;
use App\Models\PortalSetting;
use App\Models\SidebarSection;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function index(): View
    {
        $settings = PortalSetting::current();

        $sections = PortalSection::query()
            ->published()
            ->ordered()
            ->with(['items' => fn ($query) => $query->visibleNow()->ordered()])
            ->get()
            ->filter(fn (PortalSection $section): bool => $section->items->isNotEmpty())
            ->values();

        $sidebarSections = SidebarSection::query()
            ->published()
            ->ordered()
            ->with(['items' => fn ($query) => $query->published()->ordered()])
            ->get()
            ->filter(fn (SidebarSection $section): bool => $section->items->isNotEmpty())
            ->values();

        $modalItems = $sections
            ->flatMap(fn (PortalSection $section) => $section->items)
            ->filter(fn ($item): bool => $item->opens_modal)
            ->map(fn ($item): array => $item->toModalPayload())
            ->values();

        return view('portal.index', [
            'settings' => $settings,
            'sections' => $sections,
            'sidebarSections' => $sidebarSections,
            'modalItems' => $modalItems,
        ]);
    }
}
