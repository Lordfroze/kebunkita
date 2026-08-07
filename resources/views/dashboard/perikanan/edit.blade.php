@extends('layouts.app')

@section('title', 'Edit Data Perikanan')

@section('content')
    <div class="animate-fade-in mx-auto max-w-2xl space-y-5">
        <section class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-xl font-bold text-slate-800">Edit Data Perikanan</h2>
                <p class="text-sm text-slate-500">Perbarui data kegiatan #{{ $task->id }}.</p>
            </div>
            <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
            </a>
        </section>

        <div class="card p-6">
            <form method="POST" action="{{ url('/dashboard/perikanan/' . $task->id) }}" class="space-y-4">
                @method('PATCH')
                @csrf

                <div>
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $task->created_at->format('Y-m-d') }}" class="form-input" required>
                </div>

                <div>
                    <label for="kegiatan" class="form-label">Kegiatan</label>
                    <input type="text" id="kegiatan" name="kegiatan" value="{{ $task->kegiatan }}" class="form-input" required>
                </div>

                <div>
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ $task->lokasi }}" class="form-input" required>
                </div>

                <div>
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" id="biaya" name="biaya" value="{{ $task->biaya }}" class="form-input">
                </div>

                <div>
                    <label for="musim_panen" class="form-label">Musim Panen</label>
                    <input type="number" id="musim_panen" name="musim_panen" value="{{ $task->musim_panen ?? 1 }}" class="form-input">
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 pt-4 sm:flex-row sm:justify-end">
                    <a href="{{ url('dashboard/perikanan') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" class="h-4 w-4"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
