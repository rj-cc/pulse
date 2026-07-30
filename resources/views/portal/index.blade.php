@use('Illuminate\Support\Facades\Vite')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->organization_name }}</title>
    @if ($settings->logoUrl())
        <link rel="icon" href="{{ $settings->logoUrl() }}">
    @else
        <link rel="icon" href="{{ asset('/images/samplelogo.svg') }}" type="image/svg+xml">
    @endif
    {!! Vite::fonts($settings->font_style->fontAliases()) !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="portal-page font-sans antialiased bg-background text-foreground"
    style="{{ $settings->appearanceStyle() }}"
    x-data="portalPage(@js($modalItems))"
>
    @include('portal.partials.topbar')
    @include('portal.partials.header')
    @include('portal.partials.hero')

    <main class="py-6 sm:py-8">
        <x-ui.container size="xl">
            <div class="grid gap-8 lg:grid-cols-[1.65fr_1fr] lg:gap-7 lg:items-start">
                <div class="space-y-10 min-w-0">
                    @foreach ($sections as $section)
                        @php
                            $partial = match ($section->layout) {
                                \App\Enums\PortalSectionLayout::Carousel => 'portal.partials.sections.carousel',
                                \App\Enums\PortalSectionLayout::IconGrid => 'portal.partials.sections.icon-grid',
                                \App\Enums\PortalSectionLayout::InfoGrid => 'portal.partials.sections.info-grid',
                            };
                        @endphp
                        @include($partial, ['section' => $section])
                    @endforeach
                </div>

                <aside class="lg:sticky lg:top-24 space-y-4 min-w-0">
                    @include('portal.partials.sidebar')
                </aside>
            </div>
        </x-ui.container>
    </main>

    @include('portal.partials.footer')
    @include('portal.partials.detail-sheet')
</body>
</html>
