<div class="flex items-end justify-between gap-4">
    <div>
        <h2 class="font-heading text-lg font-bold tracking-tight text-primary sm:text-xl">
            {{ $section->title }}
        </h2>
        <div class="portal-hairline mt-2" aria-hidden="true"></div>
    </div>
    @if ($section->hasExpandableItems())
        <button
            type="button"
            class="inline-flex items-center gap-1 text-sm font-medium text-primary transition-colors hover:text-primary/80 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
            @click="expanded = ! expanded"
            :aria-expanded="expanded"
        >
            <span x-text="expanded ? @js($section->collapse_label ?: 'Show less') : @js($section->view_all_label)"></span>
            <x-lucide-chevron-right
                class="size-4 transition-transform duration-200"
                x-bind:class="expanded ? 'rotate-90' : ''"
                aria-hidden="true"
            />
        </button>
    @endif
</div>
