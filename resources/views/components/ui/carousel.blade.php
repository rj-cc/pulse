{{--
    Carousel root — holds the active index and exposes prev/next.
      orientation  horizontal (default) | vertical. Vertical needs a height on
                   <x-ui.carousel-content> (e.g. class="h-[240px]").
      swipe        enable touch/pen swipe to change slides (default true; mouse uses the arrows).
      autoplay     auto-advance interval in ms (0 = off). Wraps to the first slide.
--}}
@props(['orientation' => 'horizontal', 'swipe' => true, 'autoplay' => 0])

<div
    data-slot="carousel"
    role="region"
    aria-roledescription="carousel"
    x-data="{
        index: 0,
        count: 0,
        orientation: @js($orientation),
        swipe: @js((bool) $swipe),
        autoplayMs: @js((int) $autoplay),
        timer: null,
        drag: { active: false, start: 0 },
        init() {
            this.count = this.$refs.track ? this.$refs.track.children.length : 0;
            this.startAutoplay();
        },
        destroy() { this.stopAutoplay(); },
        get canPrev() { return this.count > 1 },
        get canNext() { return this.count > 1 },
        prev() {
            if (this.count === 0) return;
            this.index = this.index <= 0 ? this.count - 1 : this.index - 1;
        },
        next() {
            if (this.count === 0) return;
            this.index = this.index >= this.count - 1 ? 0 : this.index + 1;
        },
        startAutoplay() {
            this.stopAutoplay();
            if (! this.autoplayMs || this.count < 2) return;
            this.timer = setInterval(() => this.next(), this.autoplayMs);
        },
        stopAutoplay() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        onPointerDown(e) {
            if (!this.swipe || e.pointerType === 'mouse') return;
            this.drag.active = true;
            this.drag.start = this.orientation === 'vertical' ? e.clientY : e.clientX;
            this.stopAutoplay();
        },
        onPointerUp(e) {
            if (!this.drag.active) return;
            this.drag.active = false;
            const end = this.orientation === 'vertical' ? e.clientY : e.clientX;
            const d = end - this.drag.start;
            const threshold = 40;
            if (d <= -threshold) this.next();
            else if (d >= threshold) this.prev();
            this.startAutoplay();
        }
    }"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
    @focusin="stopAutoplay()"
    @focusout="startAutoplay()"
    @keydown.left.prevent="prev()"
    @keydown.right.prevent="next()"
    tabindex="0"
    {{ $attributes->twMerge('relative') }}
>
    {{ $slot }}
</div>
