<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — KebunKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/kebunkita.css', 'resources/js/kebunkita.js'])
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans text-slate-700 antialiased">
    <div class="flex min-h-screen">
        {{-- Brand panel (desktop) --}}
        <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-emerald-700 p-12 text-white lg:flex">
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-emerald-500/30 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-16 h-80 w-80 rounded-full bg-lime-400/20 blur-2xl"></div>
            <div class="pointer-events-none absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 28px 28px;"></div>

            <div class="relative flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 text-white ring-1 ring-white/25">
                    <i data-lucide="sprout" class="h-6 w-6"></i>
                </span>
                <div>
                    <p class="font-display text-xl font-extrabold leading-tight">KebunKita</p>
                    <p class="text-xs font-medium text-emerald-100/80">Agribusiness Management</p>
                </div>
            </div>

            <div class="relative max-w-md">
                <h1 class="font-display text-3xl font-extrabold leading-snug">
                    Kelola kebun & bisnis pertanian Anda dalam satu dashboard.
                </h1>
                <p class="mt-4 text-emerald-50/90">
                    Pantau produksi, stok, keuangan, dan aktivitas perawatan secara real-time dengan tampilan yang ringan dan mudah digunakan.
                </p>
                <ul class="mt-8 space-y-3 text-sm">
                    @php
                        $features = [
                            ['sprout', 'Manajemen tanaman & lahan'],
                            ['fish', 'Monitoring kegiatan perikanan'],
                            ['wallet', 'Rekap pemasukan & pengeluaran'],
                            ['chart-column', 'Analitik & laporan visual'],
                        ];
                    @endphp
                    @foreach ($features as [$ic, $label])
                        <li class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/15">
                                <i data-lucide="{{ $ic }}" class="h-4 w-4"></i>
                            </span>
                            <span class="text-emerald-50">{{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <p class="relative text-xs text-emerald-100/70">KebunKita &copy; {{ date('Y') }} · Solusi agribisnis modern</p>
        </div>

        {{-- Form panel --}}
        <div class="flex flex-1 items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm shadow-emerald-600/30">
                        <i data-lucide="sprout" class="h-6 w-6"></i>
                    </span>
                    <div>
                        <p class="font-display text-xl font-extrabold leading-tight text-slate-800">KebunKita</p>
                        <p class="text-xs font-medium text-slate-400">Agribusiness Management</p>
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
