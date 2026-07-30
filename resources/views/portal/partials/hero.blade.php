@php
    $heroAuroraColors = [
        'var(--primary)', 'var(--destructive)', 'var(--brand-accent)', 'var(--destructive)'
    ];
@endphp

<x-ui.aurora
    class="portal-hero rounded-none border-0 bg-primary text-primary-foreground min-h-[280px] sm:min-h-[320px] md:min-h-[340px]"
    :colors="$heroAuroraColors"
    :blur="50"
    :speed="30"
>
    <x-ui.container size="xl" class="relative z-10 flex min-h-[280px] items-end sm:min-h-[320px] md:min-h-[340px]">
        <div class="w-full pb-10 pt-14 sm:pb-12 sm:pt-16">
            <p
                class="mb-2 text-xs font-semibold uppercase tracking-[0.14em] text-[var(--brand-accent)] portal-reveal-up portal-reveal-delay-2"
                x-text="heroDate"
            ></p>
            <div class="flex items-start gap-3 sm:gap-4 portal-reveal-up portal-reveal-delay-3">
                <span
                    class="portal-hero-emoji text-4xl leading-none select-none sm:text-5xl"
                    x-text="greetingEmoji"
                    x-show="greetingVisible"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    aria-hidden="true"
                ></span>
                <h1
                    class="font-heading text-3xl font-extrabold tracking-tight text-balance sm:text-4xl md:text-[2.75rem]"
                    x-show="greetingVisible"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                >
                    <span x-text="greetingText"></span>
                </h1>
            </div>
            @if (filled($settings->hero_subtitle))
                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-primary-foreground/85 sm:text-base portal-reveal-up portal-reveal-delay-4">
                    {{ $settings->hero_subtitle }}
                </p>
            @endif
            @if (filled($settings->hero_motto))
                <p class="mt-2 max-w-xl text-sm font-medium italic text-[var(--brand-accent)] portal-reveal-up portal-reveal-delay-4">
                    {{ $settings->hero_motto }}
                </p>
            @endif
        </div>
    </x-ui.container>
</x-ui.aurora>
