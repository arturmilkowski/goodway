        <footer class="border-t border-x border-black pt-2 px-2 mt-8 mb-4">
            <section class="text-xs">
                &copy; GoodWay &mdash;
                @if (App::environment(['local', 'staging']))
                Root name: <strong>{{ Route::currentRouteName() }}</strong>
                &mdash; Root action: <strong>{{ Route::currentRouteAction() }}</strong>
                @auth
                &mdash;
                <x-heroicon-o-user class="inline-flex items-center w-[1em] h-[1em]" /> {{ Auth::user()->name }} {{ Auth::user()->profile?->surname }}
                @endauth
                &mdash; <x-fab-laravel class="inline-flex items-center w-[1em] h-[1em]" /> {{ Illuminate\Foundation\Application::VERSION }}
                &mdash; <x-fab-php class="inline-flex items-center w-[2em] h-[2em]" /> {{ PHP_VERSION }}
                @else
                FUNDACJA GOOD-WAY
                33-140 LISIA GÓRA
                ZACZARNIE 166B
                NIP: PL9930715376
                @endif
            </section>
        </footer>