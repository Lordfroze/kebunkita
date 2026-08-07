@props(['type' => 'success', 'message' => ''])
@php
    $map = [
        'success' => ['border-emerald-200 bg-emerald-50 text-emerald-800', 'circle-check', 'text-emerald-600'],
        'error' => ['border-red-200 bg-red-50 text-red-800', 'circle-alert', 'text-red-600'],
        'info' => ['border-sky-200 bg-sky-50 text-sky-800', 'info', 'text-sky-600'],
    ];
    $c = $map[$type] ?? $map['success'];
@endphp
@if ($message)
    <div class="flex items-start gap-3 rounded-xl border p-4 {{ $c[0] }}">
        <span class="mt-0.5 {{ $c[2] }}"><i data-lucide="{{ $c[1] }}" class="h-5 w-5"></i></span>
        <p class="text-sm font-medium">{{ $message }}</p>
    </div>
@endif
