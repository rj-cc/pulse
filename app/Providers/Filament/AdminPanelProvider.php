<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Notifications\Livewire\Notifications;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        Notifications::alignment(Alignment::Right);
        Notifications::verticalAlignment(VerticalAlignment::End);

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Indigo,
                'primary' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Mulish')
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Pulse')
            ->brandLogo(asset('/images/samplelogo.svg'))
            ->favicon(asset('/images/samplelogo.svg'))
            ->brandLogoHeight('2rem')
            ->topbar(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                AuthDesignerPlugin::make()
                    ->login(fn (AuthPageConfig $config) => $config
                        ->media(asset('/images/backgroundsample.jpg'), alt: 'image')
                        ->mediaPosition(MediaPosition::Left)
                        ->mediaSize('40%')
                        ->usingPage(Login::class)
                    )
                    ->registration(fn (AuthPageConfig $config) => $config
                        ->media(asset('/images/backgroundsample.jpg'), alt: 'image')
                        ->mediaPosition(MediaPosition::Right)
                        ->mediaSize('40%')
                        ->usingPage(Register::class)
                    )
                    ->passwordReset(fn ($config) => $config
                        ->media(asset('/images/backgroundsample.jpg'), alt: 'image')
                        ->mediaPosition(MediaPosition::Cover)
                        ->blur(2)
                    )
                    ->themeToggle(),
            ])
            ->unsavedChangesAlerts()
            ->errorNotifications()
            ->registerErrorNotification(
                title: 'An error occurred',
                body: 'Something went wrong. Please try again.',
            )
            ->registerErrorNotification(
                title: 'Record not found',
                body: 'A record you are looking for does not exist.',
                statusCode: 404,
            )
            ->registerErrorNotification(
                title: 'Page expired',
                body: 'Your session timed out. Refresh the page and try again.',
                statusCode: 419,
            )
            ->registerErrorNotification(
                title: 'Too many requests',
                body: 'Please wait a moment before trying again.',
                statusCode: 429,
            )
            ->registerErrorNotification(
                title: 'Server error',
                body: 'Something went wrong on our end. Please try again later.',
                statusCode: 500,
            )
            ->registerErrorNotification(
                title: 'Session expired',
                body: 'Please log in again to continue.',
                statusCode: 401,
            )
            ->hiddenErrorNotification(403)
            ->hiddenErrorNotification(422)
            ->disabledErrorNotification(503)
            ->spa();
    }
}
