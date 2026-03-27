        <footer class="border-t border-black pt-2">
            <section class="text-xs">
                        &copy; GoodWay &mdash;
                        @if (App::environment(['local', 'staging']))

                        Root name: <strong>{{ Route::currentRouteName() }}</strong>
                        &mdash; Root action: <strong>{{ Route::currentRouteAction() }}</strong>
                        @auth
                        &mdash;
                        Zalogowany: {{ Auth::user()->name }} {{ Auth::user()->profile?->surname }}
                        @endauth
                        &mdash; Laravel: {{ Illuminate\Foundation\Application::VERSION }}
                        &mdash; PHP: {{ PHP_VERSION }}
                        @endif
            </section>
        </footer>
