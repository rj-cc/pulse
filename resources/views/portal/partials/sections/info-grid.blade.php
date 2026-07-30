@php
    $tagTone = static function (?string $style): array {
        return match ($style) {
            'memo', 'important' => ['tone' => 'danger', 'variant' => 'soft'],
            'event' => ['tone' => 'warning', 'variant' => 'soft'],
            'new' => ['tone' => 'info', 'variant' => 'soft'],
            default => ['tone' => 'neutral', 'variant' => 'soft'],
        };
    };
@endphp

<section class="portal-reveal space-y-4" x-data="{ expanded: false }">
    @include('portal.partials.sections._header', ['section' => $section])

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($section->items as $index => $item)
            <button
                type="button"
                x-show="expanded || {{ $index }} < {{ $section->initial_items_count ?? $section->items->count() }}"
                x-cloak
                class="group overflow-hidden rounded-lg border border-border bg-card text-left shadow-none transition-colors hover:border-primary/35 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                @if ($item->opens_modal)
                    @click="openDetail({{ $item->id }})"
                @elseif (filled($item->url))
                    onclick="window.location.href='{{ $item->url }}'"
                @endif
            >
                @if ($item->imageUrl())
                    <x-ui.image
                        src="{{ $item->imageUrl() }}"
                        alt="{{ $item->title }}"
                        ratio="16 / 10"
                        rounded="rounded-none"
                        class="border-b border-border"
                    />
                @else
                    <div
                        class="aspect-[16/10] w-full bg-primary"
                        @if (filled($item->accent_color))
                            style="background: linear-gradient(135deg, {{ $item->accent_color }}, color-mix(in srgb, {{ $item->accent_color }} 65%, black));"
                        @endif
                    ></div>
                @endif

                <div class="space-y-2 p-4">
                    @if (filled($item->tag_label))
                        @php $mapped = $tagTone($item->tag_style); @endphp
                        <x-ui.badge :tone="$mapped['tone']" :variant="$mapped['variant']" size="sm">
                            <x-lucide-file-text class="size-3" aria-hidden="true" />
                            {{ $item->tag_label }}
                        </x-ui.badge>
                    @endif
                    <p class="font-heading text-sm font-semibold leading-snug text-foreground group-hover:text-primary">
                        {{ $item->title }}
                    </p>
                    @if (filled($item->meta_text))
                        <p class="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
                            <x-lucide-clock class="size-3.5" aria-hidden="true" />
                            {{ $item->meta_text }}
                        </p>
                    @else
                        <p class="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
                            <x-lucide-clock class="size-3.5" aria-hidden="true" />
                            {{ $item->published_at->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </button>
        @endforeach
    </div>
</section>
