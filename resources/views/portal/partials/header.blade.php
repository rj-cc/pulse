<header
    class="sticky top-0 z-50 border-b border-border bg-card/95 backdrop-blur-md transition-shadow portal-reveal-up portal-reveal-delay-1"
    :class="{ 'shadow-md': scrolled }"
>
    <x-ui.container size="xl" class="flex items-center gap-4 py-3">
        <div class="flex min-w-0 items-center gap-3.5">
            <x-ui.avatar class="size-12 ring-2 ring-[var(--brand-accent)]/40 shadow-sm">
                @if ($settings->logoUrl())
                    <x-ui.avatar-image src="{{ $settings->logoUrl() }}" alt="{{ $settings->organization_name }}" />
                @endif
                <x-ui.avatar-fallback class="bg-primary text-primary-foreground text-xs font-bold">
                    {{ strtoupper(substr($settings->organization_name, 0, 2)) }}
                </x-ui.avatar-fallback>
            </x-ui.avatar>

            <div class="min-w-0">
                <div class="font-heading text-[0.9375rem] font-extrabold leading-snug tracking-tight text-primary truncate">
                    {{ $settings->organization_name }}
                </div>
                @if (filled($settings->organization_tagline))
                    <div class="mt-0.5 text-xs font-medium text-muted-foreground truncate">
                        {{ $settings->organization_tagline }}
                    </div>
                @endif
                <div class="portal-hairline mt-2 max-w-[7rem]" aria-hidden="true"></div>
            </div>
        </div>
    </x-ui.container>
</header>
