<div class="bg-primary text-primary-foreground portal-reveal-up">
    <x-ui.container size="xl" class="flex flex-wrap items-center justify-between gap-3 py-2 text-xs">
        <div class="flex flex-wrap items-center gap-4 sm:gap-5">
            @if (filled($settings->topbar_phone))
                <span class="inline-flex items-center gap-1.5 opacity-90">
                    <x-lucide-phone class="size-3.5 text-[var(--brand-accent)]" aria-hidden="true" />
                    {{ $settings->topbar_phone }}
                </span>
            @endif
            @if (filled($settings->topbar_email))
                <span class="inline-flex items-center gap-1.5 opacity-90">
                    <x-lucide-mail class="size-3.5 text-[var(--brand-accent)]" aria-hidden="true" />
                    {{ $settings->topbar_email }}
                </span>
            @endif
        </div>
        <div class="flex flex-wrap items-center gap-3 sm:gap-4">
            <div class="inline-flex items-center gap-1.5 rounded-full bg-primary-foreground/10 px-3 py-0.5 font-semibold tabular-nums text-[var(--brand-accent)]">
                <x-lucide-clock class="size-3.5" aria-hidden="true" />
                <span x-text="clockTime">--:--:--</span>
            </div>
            @if (filled($settings->topbar_right_label))
                <span class="opacity-90">{{ $settings->topbar_right_label }}</span>
            @endif
        </div>
    </x-ui.container>
</div>
