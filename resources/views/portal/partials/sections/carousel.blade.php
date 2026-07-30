@php
    $badgeTone = static function (?string $style): array {
        return match ($style) {
            'important' => ['tone' => 'danger', 'variant' => 'soft'],
            'event' => ['tone' => 'warning', 'variant' => 'soft'],
            'new' => ['tone' => null, 'variant' => 'default'],
            default => ['tone' => 'neutral', 'variant' => 'soft'],
        };
    };
@endphp

<section class="portal-reveal space-y-4">
    <div>
        <h2 class="font-heading text-lg font-bold tracking-tight text-primary sm:text-xl">
            {{ $section->title }}
        </h2>
        <div class="portal-hairline mt-2" aria-hidden="true"></div>
    </div>

    <x-ui.carousel class="w-full px-1" :autoplay="6000">
        <x-ui.carousel-content class="-ml-3">
            @foreach ($section->items as $item)
                <x-ui.carousel-item class="basis-full pl-3">
                    <button
                        type="button"
                        class="group relative block w-full overflow-hidden rounded-lg border border-border text-left shadow-none outline-none focus-visible:ring-2 focus-visible:ring-ring"
                        @if ($item->opens_modal)
                            @click="openDetail({{ $item->id }})"
                        @elseif (filled($item->url))
                            onclick="window.location.href='{{ $item->url }}'"
                        @endif
                    >
                        <div
                            class="relative aspect-[16/9] w-full bg-primary"
                            @if ($item->imageUrl())
                                style="background-image: url('{{ $item->imageUrl() }}'); background-size: cover; background-position: center;"
                            @elseif (filled($item->accent_color))
                                style="background: linear-gradient(135deg, {{ $item->accent_color }}, color-mix(in srgb, {{ $item->accent_color }} 70%, black));"
                            @endif
                        >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 space-y-2 p-4 sm:p-5">
                                @if (! empty($item->badges))
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($item->badges as $badge)
                                            @php $mapped = $badgeTone($badge['style'] ?? null); @endphp
                                            <x-ui.badge
                                                :tone="$mapped['tone']"
                                                :variant="$mapped['variant']"
                                                size="sm"
                                            >
                                                {{ $badge['label'] ?? '' }}
                                            </x-ui.badge>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="font-heading text-base font-bold text-white sm:text-lg">
                                    {{ $item->title }}
                                </p>
                                @if (filled($item->meta_text))
                                    <p class="inline-flex items-center gap-1.5 text-xs text-white/80">
                                        <x-lucide-clock class="size-3.5" aria-hidden="true" />
                                        {{ $item->meta_text }}
                                    </p>
                                @else
                                    <p class="inline-flex items-center gap-1.5 text-xs text-white/80">
                                        <x-lucide-clock class="size-3.5" aria-hidden="true" />
                                        {{ $item->published_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </button>
                </x-ui.carousel-item>
            @endforeach
        </x-ui.carousel-content>

        <div class="mt-3 flex items-center justify-between gap-3 px-1">
            <x-ui.carousel-previous class="static translate-none" />
            <x-ui.carousel-next class="static translate-none" />
        </div>
    </x-ui.carousel>
</section>
