@props([
    'viewUrl' => null,
    'editUrl' => null,
    'deleteUrl' => null,
    'confirmText' => 'Yakin ingin menghapus data ini?',
])
<div class="relative inline-flex" data-dropdown>
    <button type="button" data-dropdown-toggle aria-expanded="false"
        class="icon-btn h-8 w-8 border-slate-200 text-slate-500 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700">
        <i data-lucide="ellipsis" class="h-4 w-4"></i>
    </button>
    <div data-dropdown-menu class="dropdown-menu hidden">
        @if ($viewUrl)
            <a href="{{ $viewUrl }}" class="dropdown-item">
                <i data-lucide="eye" class="h-4 w-4"></i> Lihat Detail
            </a>
        @endif
        @if ($editUrl)
            <a href="{{ $editUrl }}" class="dropdown-item">
                <i data-lucide="pencil" class="h-4 w-4"></i> Edit
            </a>
        @endif
        @if ($deleteUrl)
            <div class="dropdown-sep"></div>
            <form action="{{ $deleteUrl }}" method="POST" data-confirm-delete="{{ $confirmText }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-red-600 hover:bg-red-50 hover:text-red-700">
                    <i data-lucide="trash-2" class="h-4 w-4"></i> Hapus
                </button>
            </form>
        @endif
    </div>
</div>
