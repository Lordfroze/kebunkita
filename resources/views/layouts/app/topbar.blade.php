<div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
    <button
        id="sidebar-toggle"
        type="button"
        class="icon-btn lg:hidden"
        aria-label="Buka menu navigasi"
    >
        <i data-lucide="menu" class="h-5 w-5"></i>
    </button>

    <div class="min-w-0">
        <p class="text-xs font-medium text-slate-400">KebunKita</p>
        <h1 id="page-title" class="truncate font-display text-lg font-bold text-slate-800">@yield('title', 'Dashboard')</h1>
    </div>

    <div class="flex-1"></div>

    <div class="relative hidden md:block">
        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
            <i data-lucide="search" class="h-4 w-4"></i>
        </span>
        <input
            id="global-search"
            type="search"
            autocomplete="off"
            placeholder="Cari data…"
            class="w-56 rounded-xl border border-transparent bg-slate-100 py-2 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:w-64 focus:border-emerald-300 focus:bg-white focus:ring-2 focus:ring-emerald-100 lg:w-64"
        />
    </div>

    <div class="relative" data-dropdown>
        <button
            id="notif-btn"
            type="button"
            data-dropdown-toggle
            class="icon-btn relative"
            aria-label="Notifikasi"
        >
            <i data-lucide="bell" class="h-5 w-5"></i>
            <span class="absolute right-2 top-2 flex h-2.5 w-2.5 items-center justify-center rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>
        <div data-dropdown-menu class="dropdown-menu hidden w-72 p-0">
            <div class="border-b border-slate-100 px-4 py-3">
                <p class="text-sm font-semibold text-slate-800">Notifikasi</p>
            </div>
            <div class="max-h-80 overflow-y-auto p-2">
                <button type="button" data-notif-item class="flex w-full items-start gap-3 rounded-xl px-3 py-2.5 text-left transition-colors hover:bg-slate-50">
                    <span class="mt-0.5 text-emerald-600"><i data-lucide="info" class="h-4 w-4"></i></span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-700">Selamat datang</span>
                        <span class="block text-xs text-slate-400">Dashboard KebunKita sudah terpasang.</span>
                    </span>
                </button>
            </div>
            <div class="border-t border-slate-100 p-2">
                <button data-notif-all class="dropdown-item justify-center text-emerald-700 hover:bg-emerald-50">
                    Lihat semua notifikasi
                </button>
            </div>
        </div>
    </div>

    <div class="relative" data-dropdown>
        <button
            id="user-btn"
            type="button"
            data-dropdown-toggle
            class="flex items-center gap-2.5 rounded-xl py-1.5 pl-1.5 pr-2 transition-colors hover:bg-slate-100"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white shadow-sm">
                {{ strtoupper(substr(auth()->user()->name ?? 'AK', 0, 2)) }}
            </span>
            <span class="hidden text-left sm:block">
                <span class="block text-sm font-semibold leading-tight text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="block text-xs leading-tight text-slate-400">{{ ucfirst(auth()->user()->role ?? 'user') }}</span>
            </span>
            <i data-lucide="chevron-down" class="hidden h-4 w-4 text-slate-400 sm:block"></i>
        </button>
        <div data-dropdown-menu class="dropdown-menu hidden w-56 p-2">
            <div class="border-b border-slate-100 px-3 pb-2.5 pt-1">
                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="truncate text-xs text-slate-400">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <div class="pt-1.5">
                <button type="button" data-user-action="profil" class="dropdown-item">
                    <i data-lucide="user" class="h-4 w-4"></i> Profil Saya
                </button>
                <button type="button" data-user-action="pengaturan" class="dropdown-item">
                    <i data-lucide="settings" class="h-4 w-4"></i> Pengaturan
                </button>
                <div class="dropdown-sep"></div>
                <form method="POST" action="{{ url('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-red-600 hover:bg-red-50 hover:text-red-700">
                        <i data-lucide="log-out" class="h-4 w-4"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-user-action]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var action = btn.dataset.userAction;
                if (action === 'profil' || action === 'pengaturan') {
                    KebunKita.toast('Fitur ini hanya simulasi dalam versi integrasi.', 'info');
                }
            });
        });
        document.querySelectorAll('[data-notif-item], [data-notif-all]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                KebunKita.toast('Ini adalah notifikasi contoh.', 'info');
            });
        });
        document.querySelectorAll('[data-settings-link]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                KebunKita.toast('Halaman pengaturan masih dalam pengembangan.', 'info');
            });
        });
    });
</script>
@endpush
