<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/bulma.min.css">
    <link rel="stylesheet" href="/css/style.css">
    @hasSection('head')
        @yield('head')
    @endif
</head>
<body>
    @hasSection('navbar')
        @yield('navbar')
    @else
        <div class="navbar is-fixed-top">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>
                    <a class="navbar-burger burger"><span></span><span></span><span></span></a>
                </div>
                <div class="navbar-menu">
                    @auth
                        <div class="navbar-start">
                            @php ($hospitals = App\Models\Hospital::all())
                            @if ($hospitals->count() > 0)
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless" href="{{ route('hospitals.index') }}">@lang('layout.header.hospitals')</a>
                                    <div class="navbar-dropdown">
                                        @foreach ($hospitals->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->take(10) as $hospital)
                                            <a class="navbar-item" href="{{ route('hospitals.show', $hospital) }}">{{ $hospital->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a class="navbar-item" href="{{ route('hospitals.index') }}">@lang('layout.header.hospitals')</a>
                            @endif

                            @php ($trails = App\Models\Trail::all())
                            @if ($trails->count() > 0)
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless" href="{{ route('trails.index') }}">@lang('layout.header.trails')</a>
                                    <div class="navbar-dropdown">
                                        @foreach ($trails->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->take(10) as $trail)
                                            <a class="navbar-item" href="{{ route('trails.show', $trail) }}">{{ $trail->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a class="navbar-item" href="{{ route('trails.index') }}">@lang('layout.header.trails')</a>
                            @endif

                            @if (Auth::user()->role == App\Models\User::ROLE_ADMIN)
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless" href="{{ route('admin.home') }}">@lang('layout.header.admin.home')</a>
                                    <div class="navbar-dropdown">
                                        <a class="navbar-item" href="{{ route('admin.users.index') }}">@lang('layout.header.admin.users')</a>
                                        <a class="navbar-item" href="{{ route('admin.hospitals.index') }}">@lang('layout.header.admin.hospitals')</a>
                                        <a class="navbar-item" href="{{ route('admin.trails.index') }}">@lang('layout.header.admin.trails')</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="navbar-end">
                            <div class="navbar-item" style="display: flex; align-items: center;">
                                <img style="border-radius: 50%; margin-right: 10px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=48&d=mp" alt="{{ Auth::user()->name }}'s avatar">
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="navbar-item">
                                <div class="buttons">
                                    <a class="button is-link" href="{{ route('settings') }}">@lang('layout.header.settings')</a>
                                    <a class="button is-light" href="{{ route('auth.logout') }}">@lang('layout.header.logout')</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="navbar-end">
                            <div class="navbar-item">
                                <div class="buttons">
                                    <a class="button is-link" href="{{ route('auth.login') }}">@lang('layout.header.login')</a>
                                    <a class="button is-gray" href="{{ route('auth.register') }}">@lang('layout.header.register')</a>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @endif

    <div class="section">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <div class="footer">
        <div class="content has-text-centered">
            <p>@lang('layout.footer.authors')</p>
            <p>@lang('layout.footer.source')</p>
        </div>
    </div>

    <script src="/js/script.js"></script>
</body>
</html>
