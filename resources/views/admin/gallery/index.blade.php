@extends('components.layout.admin')
@section('title', 'Galeri')
@section('header', 'Galeri')

@section('content')
    <div class="mb-6 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <h1 class="text-2xl font-bold text-admin-text">Galeri</h1>
        <a href="{{ route('admin.gallery.create') }}"
            class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-amber-600 sm:w-auto">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Media
        </a>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        @php
            $tabs = [
                'semua' => ['label' => 'Semua'],
                'destinasi' => ['label' => 'Destinasi'],
                'fasilitas' => ['label' => 'Fasilitas'],
                'dokumentasi' => ['label' => 'Dokumentasi'],
            ];
        @endphp
        @foreach ($tabs as $key => $tab)
            <a href="{{ route('admin.gallery.index', ['filter' => $key]) }}"
                class="inline-flex min-h-11 items-center gap-1.5 rounded-lg border px-4 py-2 text-sm font-medium transition-colors
                    {{ $filter === $key
                        ? 'border-amber-500 bg-amber-500 text-white'
                        : 'border-admin-border bg-admin-card text-admin-text hover:bg-admin-bg' }}">
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @forelse($galleries as $g)
            <div class="group overflow-hidden rounded-xl border border-admin-border bg-admin-card text-admin-text">
                <div class="relative h-40">
                    @if ($g->type === 'video' && $g->path)
                        <video class="h-full w-full bg-black object-cover" muted preload="metadata">
                            <source src="{{ asset('storage/' . $g->path) }}">
                        </video>
                        <div class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/20">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-black/50 text-white">
                                <svg class="h-7 w-7 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </span>
                        </div>
                    @elseif ($g->type === 'video')
                        <div class="flex h-full w-full items-center justify-center bg-admin-bg">
                            <svg class="h-12 w-12 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    @elseif ($g->path)
                        <img src="{{ asset('storage/' . $g->path) }}" alt="Gallery" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-admin-bg">
                            <svg class="h-8 w-8 text-admin-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="absolute left-2 top-2 flex gap-1">
                        @if ($g->type === 'video')
                            <span class="rounded bg-purple-500 px-1.5 py-0.5 text-xs font-bold text-white">Video</span>
                        @endif
                        @if ($g->destinasi || $g->fasilitas)
                            <span class="rounded bg-amber-500 px-1.5 py-0.5 text-xs font-bold text-white">
                                {{ $g->destinasi ? 'Destinasi' : 'Fasilitas' }}
                            </span>
                        @endif
                    </div>

                    <div
                        class="absolute inset-0 flex items-center justify-center gap-2 bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                        <a href="{{ route('admin.gallery.show', $g->id) }}"
                            class="flex min-h-11 min-w-11 items-center justify-center rounded-lg bg-white text-blue-600 transition-colors hover:bg-blue-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" data-confirm="delete"
                            data-confirm-title="Apakah anda yakin menghapus media?"
                            data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="flex min-h-11 min-w-11 items-center justify-center rounded-lg bg-white text-red-600 transition-colors hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-3">
                    @if ($g->destinasi)
                        <p class="flex items-center gap-1.5 truncate text-xs font-medium text-admin-text">
                            <svg class="h-3.5 w-3.5 flex-shrink-0 text-admin-muted" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                            </svg>
                            <span class="truncate">{{ $g->destinasi->nama_destinasi }}</span>
                        </p>
                        @if ($g->destinasi->paket)
                            <p class="mt-0.5 truncate text-xs text-admin-muted">{{ $g->destinasi->paket->nama_paket }}</p>
                        @endif
                    @elseif($g->fasilitas)
                        <p class="flex items-center gap-1.5 truncate text-xs font-medium text-admin-text">
                            <svg class="h-3.5 w-3.5 flex-shrink-0 text-admin-muted" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="m12 2 2.9 6 6.6.95-4.75 4.63 1.12 6.54L12 17.03l-5.87 3.09 1.12-6.54L2.5 8.95 9.1 8 12 2Z" />
                            </svg>
                            <span class="truncate">{{ $g->fasilitas->nama_fasilitas }}</span>
                        </p>
                        @if ($g->fasilitas->paket)
                            <p class="mt-0.5 truncate text-xs text-admin-muted">{{ $g->fasilitas->paket->nama_paket }}</p>
                        @endif
                    @else
                        <p class="truncate text-xs text-admin-muted">Tidak dikaitkan</p>
                    @endif
                    <p class="mt-1 text-xs text-admin-muted">{{ $g->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <svg class="mx-auto mb-4 h-16 w-16 text-admin-muted" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-admin-muted">Belum ada media di galeri</p>
                <a href="{{ route('admin.gallery.create') }}"
                    class="mt-4 inline-flex min-h-11 items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-amber-600">
                    Upload Media Pertama
                </a>
            </div>
        @endforelse
    </div>
@endsection
