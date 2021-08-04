<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') - @endif{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
    window.app = @json([
        'routes'     => ['tagsAutocomplete' => route('tags.autocomplete')],
    ]);
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')
    @yield('style')
</head>
<body>
    <div id="app">

        <nav id="navbar" class="l-navbar navbar navbar-light">

                <ul class="navbar-nav mr-auto" style="flex-direction: row;">
                    @auth
                    <li class="nav-item mr-2 mr-md-3">
                        <a class="nav-link" href="{{ route('place.map') }}">{{ __('Map') }}</a>
                    </li>
                    <li class="nav-item mr-2 mr-md-3">
                        <a class="nav-link" href="{{ route('place.index') }}">{{ __('Table') }}</a>
                    </li>
                    <li class="nav-item mr-2 mr-md-3">
                        <a class="nav-link" href="{{ route('journey.index') }}">{{ __('Journeys') }}</a>
                    </li>
                    @endauth
                </ul>

                <div class="" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav ml-auto">

                        @auth

                        <li class="nav-item">
                            <div class="dropdown" style="padding-top: 0.4rem;">
                            <button class="btn btn-sm btn-outline-secondary btn-dropdown-add dropdown-toggle" type="button" id="dropdown-add" data-toggle="dropdown" aria-label="{{ __('New…') }}" aria-haspopup="true" aria-expanded="false">
                                    +
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-add">
                                    <a class="dropdown-item" href="{{ route('place.create') }}">{{ __('Place') }}</a>
                                    <a class="dropdown-item" href="{{ route('journey.create') }}">{{ __('Journey') }}</a>
                                    <a class="dropdown-item" href="{{ route('filter.create') }}">{{ __('Filter') }}</a>
                                    <a class="dropdown-item" href="{{ route('user_category.create') }}">{{ __('Category') }}</a>
                                </div>
                            </div>
                        </li>

                        @endauth

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle pr-0 text-muted" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('place.index') }}">
                                        {{ __('Places') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('journey.index') }}">
                                        {{ __('Journeys') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('filter.index') }}">
                                        {{ __('Filters') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('user_category.index') }}">
                                        {{ __('Categories') }}
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                                        {{ __('Settings') }}
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

        </nav>

        <main class="@yield('mainclass', 'py-3')">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}" ></script>

    @yield('script')

    @include('layouts.photoswipe')
</body>
</html>
