<section class="portal-reveal space-y-4" x-data="{ expanded: false }">
    @include('portal.partials.sections._header', ['section' => $section])

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @foreach ($section->items as $index => $item)
            @php
                $isLink = $item->opens_modal || filled($item->url);
                $tag = $isLink ? 'a' : 'div';
                $href = $item->opens_modal ? '#' : ($item->url ?: null);
            @endphp
            <{{ $tag }}
                x-show="expanded || {{ $index }} < {{ $section->initial_items_count ?? $section->items->count() }}"
                x-cloak
                @class([
                    'group flex flex-col items-center gap-2 rounded-lg border border-border bg-card p-4 text-center shadow-none transition-colors',
                    'hover:border-primary/40 hover:bg-muted/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring' => $isLink,
                    'ring-1 ring-[var(--brand-accent)]/50' => $item->is_featured,
                ])
                @if ($item->opens_modal)
                    href="#"
                    @click.prevent="openDetail({{ $item->id }})"
                @elseif ($href)
                    href="{{ $href }}"
                @endif
            >
                <div
                    @class([
                        'flex size-12 items-center justify-center rounded-lg bg-secondary text-primary transition-colors group-hover:bg-primary group-hover:text-primary-foreground',
                    ])
                    @if (filled($item->accent_color))
                        style="background: color-mix(in srgb, {{ $item->accent_color }} 18%, transparent); color: {{ $item->accent_color }};"
                    @endif
                >
                    <x-ui.icon :name="$item->icon ?: 'layout-grid'" class="size-5" aria-hidden="true" />
                </div>
                <p class="text-sm font-semibold leading-snug text-foreground">{{ $item->title }}</p>
                @if (filled($item->subtitle))
                    <p class="line-clamp-2 text-xs text-muted-foreground">{{ $item->subtitle }}</p>
                @endif
            </{{ $tag }}>
        @endforeach
    </div>
</section>
