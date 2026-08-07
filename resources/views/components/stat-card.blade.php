@props([
    'label' => '',
    'value' => '',
    'icon' => 'circle-check',
    'tone' => 'green',
    'footnote' => '',
])
@php
    $tones = [
        'green' => 'bg-emerald-50 text-emerald-600',
        'blue' => 'bg-sky-50 text-sky-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'violet' => 'bg-violet-50 text-violet-600',
        'red' => 'bg-red-50 text-red-600',
        'lime' => 'bg-lime-50 text-lime-600',
    ];
@endphp
<div class="card group relative overflow-hidden p-5 transition-shadow hover:shadow-md">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
            <p class="mt-2 truncate font-display text-2xl font-bold text-slate-800">{{ $value }}</p>
        </div>
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $tones[$tone] ?? $tones['green'] }}">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </span>
    </div>
    @if ($footnote)
        <p class="mt-3 text-xs text-slate-400">{{ $footnote }}</p>
    @endif
</div>
