<div class="space-y-4">
    @foreach ($sidebarSections as $sidebarSection)
        <x-ui.card class="portal-reveal rounded-lg border border-border p-4 shadow-none">
            <h3 class="mb-3 flex items-center gap-2 font-heading text-sm font-bold text-primary">
                @if (filled($sidebarSection->icon))
                    <x-ui.icon :name="$sidebarSection->icon" class="size-5" />
                @endif
                {{ $sidebarSection->title }}
            </h3>
            <div class="portal-hairline mb-3" aria-hidden="true"></div>

            <x-ui.item-group class="gap-1">
                @foreach ($sidebarSection->items as $item)
                    <x-ui.item 
                        size="sm"
                        :href="filled($item->url) ? $item->url : null"
                        class="rounded-md px-2 py-2.5 hover:bg-muted/60"
                    >
                        @if ($item->imageUrl() || filled($item->avatar_text))
                            <x-ui.avatar class="size-9">
                                @if ($item->imageUrl())
                                    <x-ui.avatar-image
                                        src="{{ $item->imageUrl() }}"
                                        alt="{{ $item->title }}"
                                    />
                                @endif
                                @if (filled($item->avatar_text))
                                    <x-ui.avatar-fallback class="bg-primary text-primary-foreground text-[0.65rem] font-bold">
                                        {{ $item->avatar_text }}
                                    </x-ui.avatar-fallback>
                                @endif
                            </x-ui.avatar>
                        @elseif (filled($item->icon))
                            <x-ui.item-media variant="icon" class="bg-secondary text-primary">
                                <x-ui.icon :name="$item->icon" class="size-4" aria-hidden="true" />
                            </x-ui.item-media>
                        @endif
                        <x-ui.item-content>
                            <x-ui.item-title>{{ $item->title }}</x-ui.item-title>
                            @if (filled($item->subtitle))
                                <x-ui.item-description>{{ $item->subtitle }}</x-ui.item-description>
                            @endif
                        </x-ui.item-content>
                        @if (filled($item->url))
                            <x-ui.item-actions>
                                <x-lucide-chevron-right class="size-4 text-muted-foreground opacity-50" aria-hidden="true" />
                            </x-ui.item-actions>
                        @endif
                    </x-ui.item>
                @endforeach
            </x-ui.item-group>
        </x-ui.card>
    @endforeach
</div>
