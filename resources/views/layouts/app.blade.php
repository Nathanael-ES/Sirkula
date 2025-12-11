<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Sirkula')</title>

    @include('layouts.bootstrap')

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* NAVBAR MODERN */
        .modern-link {
            font-weight: 500;
            padding-left: 12px !important;
            padding-right: 12px !important;
            transition: 0.25s;
        }

        .modern-link:hover {
            color: #0d6efd !important;
            transform: translateY(-1px);
        }

        .navbar-brand {
            font-size: 1.35rem;
            letter-spacing: .5px;
        }

        .navbar-nav .nav-link {
            margin-right: 18px;
        }

        .dropdown-menu {
            border-radius: 10px;
        }

        /* MODERN CATALOG UI */
        .catalog-card {
            border: 1px solid #eaeaea;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            transition: all .28s ease-in-out;
        }

        .catalog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 38px rgba(0,0,0,0.12);
            border-color: #dcdcdc;
        }

        .catalog-img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            border-bottom: 1px solid #f0f0f0;
        }

        .catalog-body {
            padding: 18px;
        }

        .catalog-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 6px;
        }

        .catalog-meta {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .badge-premium {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px !important;
            font-weight: 500;
        }

        .btn-premium {
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 14px;
        }

        .btn-icon-premium {
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 15px;
        }

        .btn-icon-premium i {
            vertical-align: middle;
        }

        /* glasphormism */
        .glass-card {
            backdrop-filter: blur(14px);
            background: rgba(255, 255, 255, 0.28);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            transition: all .28s ease-in-out;
            box-shadow: 0 8px 28px rgba(0,0,0,0.15);
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 38px rgba(0,0,0,0.22);
        }

        .glass-img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            border-bottom: 1px solid rgba(255,255,255,0.4);
        }

        .glass-body {
            padding: 18px;
            color: #333;
        }

        .glass-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .glass-meta {
            font-size: 14px;
            color: #444;
        }

        .glass-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container py-2">

        <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
            Sirkula
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('items.index') }}">{{ __('messages.items') }}</a></li>
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('admin.categories.index') }}">{{ __('messages.categories') }}</a></li>
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('donations.index') }}">{{ __('messages.donations') }}</a></li>
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('recipients.index') }}">{{ __('messages.recipients') }}</a></li>
                <li class="nav-item"><a class="nav-link modern-link" href="{{ route('distributions.index') }}">{{ __('messages.distributions') }}</a></li>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link modern-link" href="{{ route('admin.users.index') }}">
                            User Mgmt
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">

                <!-- LANG SWITCH -->
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'id') }}">ID</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">EN</a></li>
                    </ul>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout.perform') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item">{{ __('messages.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a></li>
                @endguest
            </ul>

        </div>
    </div>
</nav>

<div class="container py-3">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="{{ asset('bootstrap5.2/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
