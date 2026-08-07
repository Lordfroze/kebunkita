@php
    $currentPath = request()->path();
    $currentRoute = request()->route() ? request()->route()->getName() : null;

    $isActive = function (array $conditions) use ($currentPath, $currentRoute) {
        foreach ($conditions as $cond) {
            if ($cond === 'home' && ($currentPath === 'dashboard' || $currentPath === '' || $currentRoute === 'dashboard')) {
                return true;
            }
            if ($cond === 'weather' && $currentPath === 'weather') {
                return true;
            }
            if (is_string($cond) && str_starts_with($cond, 'prefix:')) {
                $prefix = substr($cond, 7);
                if (str_starts_with($currentPath, $prefix)) {
                    return true;
                }
            }
            if (is_string($cond) && str_starts_with($cond, 'route:')) {
                $name = substr($cond, 6);
                if ($currentRoute === $name || ($currentRoute && str_starts_with($currentRoute, $name . '.'))) {
                    return true;
                }
            }
        }
        return false;
    };

    $menu = [
        ['label' => 'Dashboard', 'icon' => 'layout-dashboard', 'href' => route('dashboard'), 'active' => $isActive(['home'])],
        ['label' => 'Perikanan', 'icon' => 'fish', 'href' => route('perikanan'), 'active' => $isActive(['prefix:dashboard/perikanan'])],
        ['label' => 'Perdagangan', 'icon' => 'scale', 'href' => route('perdagangan'), 'active' => $isActive(['prefix:dashboard/perdagangan'])],
        ['label' => 'Perkebunan', 'icon' => 'sprout', 'href' => route('perkebunan'), 'active' => $isActive(['prefix:dashboard/perkebunan'])],
        ['label' => 'Keuangan', 'icon' => 'wallet', 'href' => route('keuangan'), 'active' => $isActive(['prefix:dashboard/keuangan'])],
        ['label' => 'Laporan & Download', 'icon' => 'file-down', 'href' => route('download'), 'active' => $isActive(['prefix:download'])],
        ['label' => 'Prakiraan Cuaca', 'icon' => 'cloud-sun', 'href' => url('weather'), 'active' => $isActive(['weather'])],
    ];
@endphp

<div class="flex h-full flex-col">
    <div id="sidebar-brand" class="flex items-center gap-3 px-5 pb-4 pt-5">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm shadow-emerald-600/30">
            <i data-lucide="sprout" class="h-5 w-5"></i>
        </span>
        <div class="sidebar-brand-text min-w-0">
            <p class="font-display text-lg font-extrabold leading-tight text-slate-800">KebunKita</p>
            <p class="truncate text-[11px] font-medium text-slate-400">Agribusiness Management</p>
        </div>
    </div>

    <button
        id="sidebar-collapse-btn"
        type="button"
        class="mx-3 mb-1 hidden items-center justify-center gap-2 rounded-xl border border-slate-200 py-2 text-xs font-semibold text-slate-500 transition-colors hover:bg-slate-50 hover:text-emerald-700 lg:flex"
        title="Ciutkan menu"
    >
        <i data-lucide="chevron-left" class="h-4 w-4"></i>
        <span class="sidebar-label">Ciutkan</span>
    </button>

    <nav class="flex-1 overflow-y-auto px-3 py-2">
        <div class="sidebar-section mb-5">
            <p class="sidebar-section-title">Menu Utama</p>
            <ul class="space-y-1">
                @foreach ($menu as $item)
                    <li>
                        <a href="{{ $item['href'] }}"
                           data-route
                           class="nav-item {{ $item['active'] ? 'nav-active' : '' }}"
                           title="{{ $item['label'] }}">
                            <span class="nav-icon"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i></span>
                            <span class="sidebar-label">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-section-title">Administrasi</p>
            <ul class="space-y-1">
                @if (auth()->check() && auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                           data-route
                           class="nav-item {{ $isActive(['route:admin.users']) ? 'nav-active' : '' }}"
                           title="Manajemen User">
                            <span class="nav-icon"><i data-lucide="users" class="h-5 w-5"></i></span>
                            <span class="sidebar-label">Manajemen User</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="#" data-route data-settings-link
                       class="nav-item"
                       title="Pengaturan">
                        <span class="nav-icon"><i data-lucide="settings" class="h-5 w-5"></i></span>
                        <span class="sidebar-label">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="border-t border-slate-100 p-3">
        <div id="sidebar-user" class="flex cursor-pointer items-center gap-3 rounded-xl px-2 py-2 transition-colors hover:bg-slate-50">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-800">
                {{ strtoupper(substr(auth()->user()->name ?? 'AK', 0, 2)) }}
            </span>
            <div class="sidebar-user-info min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="truncate text-xs text-slate-400">{{ auth()->user()->email ?? 'admin@kebunkita.id' }}</p>
            </div>
            <i data-lucide="chevron-up" class="sidebar-user-info h-4 w-4 shrink-0 text-slate-400"></i>
        </div>
    </div>
</div>
