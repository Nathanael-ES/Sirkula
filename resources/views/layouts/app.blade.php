<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Sirkula')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body { font-family: 'Poppins', sans-serif !important; }

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
        letter-spacing: 0.5px;
    }

    .dropdown-menu {
        border-radius: 10px;
    }

    .navbar-nav .nav-link {
        /* jarak antar menu */
        margin-right: 18px; 
    }
</style>

</head>
<body>
{{-- navbar --}}

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
                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('items.index') }}">{{ __('messages.items') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('donations.index') }}">{{ __('messages.donations') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('distributions.index') }}">{{ __('messages.distributions') }}</a></li>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            User Management
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                <!-- Language Switch -->
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'id') }}">ID</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">EN</a></li>
                    </ul>
                </li>

                <!-- User dropdown -->
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

<div class="container">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    
</script>
</body>
</html>
