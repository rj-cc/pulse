document.addEventListener('alpine:init', () => {
    Alpine.store('portalDetail', {
        item: null,
    });

    Alpine.data('portalPage', (modalItems = []) => ({
        clockTime: '--:--:--',
        greetingEmoji: '🌤️',
        greetingText: 'Good morning',
        greetingVisible: true,
        greetingPeriodKey: 'morning',
        heroDate: '',
        scrolled: false,
        items: modalItems,
        year: new Date().getFullYear(),

        init() {
            this.updateClock();
            this.applyGreetingPeriod(this.getGreetingPeriod());
            this.setDate();
            setInterval(() => this.tick(), 60000);
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            }, { passive: true });

            const revealEls = document.querySelectorAll('.portal-reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
            revealEls.forEach((el) => revealObserver.observe(el));
        },

        getGreetingPeriod() {
            const hourStr = new Date().toLocaleTimeString('en-PH', {
                hour: 'numeric',
                hour12: false,
                timeZone: 'Asia/Manila',
            });
            const hour = parseInt(hourStr, 10);

            if (hour >= 12 && hour < 18) {
                return { emoji: '⛅', text: 'Good afternoon', periodKey: 'afternoon' };
            }

            if (hour >= 18 || hour < 5) {
                return { emoji: '🌙', text: 'Good evening', periodKey: 'evening' };
            }

            return { emoji: '🌤️', text: 'Good morning', periodKey: 'morning' };
        },

        applyGreetingPeriod({ emoji, text, periodKey }) {
            this.greetingEmoji = emoji;
            this.greetingText = text;
            this.greetingPeriodKey = periodKey;
            this.greetingVisible = true;
        },

        async transitionGreetingPeriod(period) {
            this.greetingVisible = false;
            await new Promise((resolve) => setTimeout(resolve, 150));
            this.applyGreetingPeriod(period);
        },

        tick() {
            this.updateClock();

            const period = this.getGreetingPeriod();
            if (period.periodKey !== this.greetingPeriodKey) {
                this.transitionGreetingPeriod(period);
            }
        },

        updateClock() {
            this.clockTime = new Date().toLocaleTimeString('en-PH', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
                timeZone: 'Asia/Manila',
            });
        },

        setDate() {
            this.heroDate = new Date().toLocaleDateString('en-PH', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'Asia/Manila',
            });
        },

        openDetail(id) {
            const item = this.items.find((entry) => entry.id === id) || null;
            Alpine.store('portalDetail').item = item;
            if (item) {
                this.$dispatch('open-sheet-portal-detail');
            }
        },
    }));
});
