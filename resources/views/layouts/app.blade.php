<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — KebunKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/kebunkita.css', 'resources/js/kebunkita.js'])
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans text-slate-700 antialiased">
    <div id="sidebar-backdrop"></div>

    <aside id="sidebar-root" aria-label="Navigasi utama">
        @include('layouts.app.sidebar')
    </aside>

    <div id="main-wrap" class="main-wrap">
        <header id="topbar-root" class="sticky top-0 z-30 border-b border-slate-200 bg-white/85 backdrop-blur-md">
            @include('layouts.app.topbar')
        </header>

        <main id="content-root" class="flex-1 px-4 pb-10 pt-6 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <footer class="px-4 pb-6 text-center text-xs text-slate-400 sm:px-6 lg:px-8">
            KebunKita &copy; {{ date('Y') }} &middot; Agribusiness Management Dashboard
        </footer>
    </div>

    <div id="modal-root"></div>
    <div id="toast-root"
        class="pointer-events-none fixed right-4 top-4 z-[90] flex w-[320px] max-w-[calc(100vw-2rem)] flex-col gap-3"></div>

    @stack('scripts')
</body>

</html>
