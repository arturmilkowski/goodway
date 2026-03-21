        <footer>
            <hr />
            <section>
                <small>
                        &copy; GoodWay &mdash;
                        @if (App::environment(['local', 'staging']))

                        Root name: <strong>{{ Route::currentRouteName() }}</strong>
                        &mdash; Root action: <strong>{{ Route::currentRouteAction() }}</strong>
                        @auth
                        &mdash;
                        Zalogowany: {{ Auth::user()->name }} {{ Auth::user()->profile?->surname }}
                        @endauth
                        &mdash; L: {{ Illuminate\Foundation\Application::VERSION }}
                        &mdash; P: {{ PHP_VERSION }}
                        @endif

                </small>
            </section>
        </footer>
