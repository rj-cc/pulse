<x-ui.sheet id="portal-detail">
    <x-ui.sheet-content
        side="right"
        class="w-[min(96vw,1100px)] sm:max-w-none gap-0 overflow-hidden p-0"
    >
        <x-ui.sheet-header class="border-b border-border px-5 pt-5 pb-4">
            <div class="mb-2 flex flex-wrap gap-2" x-show="$store.portalDetail.item?.badges?.length">
                <template x-for="(badge, index) in ($store.portalDetail.item?.badges || [])" :key="index">
                    <span
                        class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2 py-0.5 text-xs font-medium text-secondary-foreground"
                        :class="{
                            'bg-destructive/10 text-destructive': badge.style === 'important',
                            'bg-primary text-primary-foreground': badge.style === 'new',
                            'bg-[var(--brand-accent)] text-primary': badge.style === 'event',
                        }"
                        x-text="badge.label"
                    ></span>
                </template>
            </div>
            <p
                class="text-xs font-bold uppercase tracking-wide text-muted-foreground"
                x-show="$store.portalDetail.item?.tag_label"
                x-text="$store.portalDetail.item?.tag_label"
            ></p>
            <x-ui.sheet-title x-text="$store.portalDetail.item?.title || ''"></x-ui.sheet-title>
            <x-ui.sheet-description
                x-show="$store.portalDetail.item?.meta_text"
                x-text="$store.portalDetail.item?.meta_text || ''"
            ></x-ui.sheet-description>
        </x-ui.sheet-header>

        <x-ui.scroll-area class="min-h-0 flex-1 px-5 py-5">
            <template x-if="$store.portalDetail.item?.image_url">
                <img
                    class="mb-4 w-full rounded-lg object-cover"
                    :src="$store.portalDetail.item.image_url"
                    :alt="$store.portalDetail.item.title"
                >
            </template>
            <div class="prose prose-sm max-w-none text-foreground" x-html="$store.portalDetail.item?.body || ''"></div>
        </x-ui.scroll-area>
    </x-ui.sheet-content>
</x-ui.sheet>
