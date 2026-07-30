<footer class="mt-4 border-t border-border bg-card">
    <x-ui.container size="xl" class="py-8">
        @if (filled($settings->footer_motto))
            <p class="mb-4 text-center text-sm font-medium text-muted-foreground">
                {{ $settings->footer_motto }}
            </p>
        @endif

        @if (! empty($settings->footer_links))
            <div class="mb-5 flex flex-wrap items-center justify-center gap-x-5 gap-y-2">
                @foreach ($settings->footer_links as $link)
                    <x-ui.link
                        :href="$link['url'] ?? '#'"
                        variant="muted"
                        class="text-sm no-underline hover:text-foreground"
                    >
                        {{ $link['label'] ?? '' }}
                    </x-ui.link>
                @endforeach
            </div>
        @endif

        <x-ui.separator class="mb-4" />

        <div class="flex flex-wrap items-center justify-between gap-2 text-[0.7rem] text-muted-foreground">
            <span>© <span x-text="year"></span> {{ $settings->footer_copyright }}</span>
            @if (filled($settings->footer_right_label))
                <span>{{ $settings->footer_right_label }}</span>
            @endif
        </div>
    </x-ui.container>
</footer>
