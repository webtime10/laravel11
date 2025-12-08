<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Request;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            // контент панели на всю ширину
            ->maxContentWidth(MaxWidth::Full)

            ->colors([
                'primary' => Color::Amber,
            ])

            // автопоиск ресурсов/страниц/виджетов
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

            // явные страницы (дополнительно к discoverPages)
            ->pages([
                \Filament\Pages\Dashboard::class,
                \App\Filament\Pages\HomePage::class,
            ])

            // middleware стек
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            // локальный CSS для страниц продуктов (index/create/edit)
            ->renderHook('panels::head.end', function (): string {
                if (Request::routeIs('filament.admin.resources.products.*')) {
                    // класс .product-half можно навесить на Section/Grid через ->extraAttributes(['class' => 'product-half'])
                    return <<<HTML
<style>
  .product-half {
    --cols-default: repeat(1, minmax(0, 1fr));
    --cols-lg:      repeat(2, minmax(0, 1fr));
  }
</style>
HTML;
                }
                return '';
            });
    }
}
