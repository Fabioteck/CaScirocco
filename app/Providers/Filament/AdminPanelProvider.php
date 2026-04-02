<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin') 
            ->brandName('Cà Scirocco')
            ->colors([
                'primary' => Color::Amber,
            ])
            
            // --- DISABILITIAMO IL LOGIN ---
            // ->login()  <-- Commentato: niente più form di login

            ->sidebarWidth('18rem')
            
            ->renderHook(
                'panels::head.done',
                fn (): string => Blade::render('<style>
                    @media (min-width: 1280px) {
                        .fi-wi-stats-overview > div { 
                            display: grid !important; 
                            grid-template-columns: repeat(5, minmax(0, 1fr)) !important; 
                            gap: 0.75rem !important;
                        }
                        .fi-wi-stats-overview-stat { padding: 0.75rem 1rem !important; }
                        .fi-wi-stats-overview-stat .text-3xl { font-size: 1.5rem !important; }
                    }
                </style>'),
            )

            ->navigationGroups([
                NavigationGroup::make('Amministrazione'),
                NavigationGroup::make('Ristorante'),
                NavigationGroup::make('Sito'),
            ])

            ->navigationItems([
                NavigationItem::make('Facebook')
                    ->url('https://www.facebook.com', true)
                    ->icon('heroicon-o-share')
                    ->group('Sito')
                    ->sort(3),

                NavigationItem::make('Instagram')
                    ->url('https://www.instagram.com', true)
                    ->icon('heroicon-o-camera')
                    ->group('Sito')
                    ->sort(4),

                NavigationItem::make('TripAdvisor')
                    ->url('https://www.tripadvisor.it', true)
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->group('Sito')
                    ->sort(5),

                NavigationItem::make('Booking')
                    ->url('https://www.booking.com', true)
                    ->icon('heroicon-o-building-office-2')
                    ->group('Sito')
                    ->sort(6),
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([\App\Filament\Pages\Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
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
            // --- DISABILITIAMO IL MIDDLEWARE DI AUTENTICAZIONE ---
            ->authMiddleware([]) // Lasciamo vuoto per rendere tutto pubblico
            ->widgets([
                \Filament\Widgets\AccountWidget::class, // Percorso corretto per il widget di Filament
                \App\Filament\Widgets\WeatherWidget::class,
                \App\Filament\Widgets\TablesTomorrowWidget::class,
                \App\Filament\Widgets\RoomArrivalsTomorrowWidget::class,
            ])

            ->plugins([
                FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->editable(),
            ]);
            
    }
}
