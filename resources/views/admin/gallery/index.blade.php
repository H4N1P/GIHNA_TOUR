@extends('components.layout.admin')
@section('title', 'Galeri')
@section('header', 'Galeri')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Galeri</h1>
        <a href="{{ route('admin.gallery.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Media
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @forelse($galleries as $g)
            <div
                class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden group">
                <div class="relative h-40">
                    @if ($g->type === 'video')
                        <div class="w-full h-full bg-neutral-800 flex items-center justify-center">
                            <svg class="w-12 h-12 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    @elseif ($g->path)
                        <img src="{{ asset('storage/' . $g->path) }}" alt="Gallery" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Badge type --}}
                    <div class="absolute top-2 left-2 flex gap-1">
                        @if ($g->type === 'video')
                            <span class="px-1.5 py-0.5 text-xs font-bold rounded bg-purple-500 text-white">Video</span>
                        @endif
                        @if ($g->tempat || $g->fasilitas)
                            <span class="px-1.5 py-0.5 text-xs font-bold rounded bg-amber-500 text-white">
                                {{ $g->tempat ? 'Tempat' : 'Fasilitas' }}
                            </span>
                        @endif
                    </div>

                    {{-- Overlay aksi --}}
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ route('admin.gallery.show', $g->id) }}"
                            class="p-2 bg-white rounded-lg text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST"
                            data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus media?"
                            data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="p-2 bg-white rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-3">
                    @if ($g->tempat)
                        <p class="text-xs font-medium text-neutral-700 dark:text-neutral-300 truncate">
                            📍 {{ $g->tempat->nama_tempat }}
                        </p>
                        @if ($g->tempat->paket)
                            <p class="text-xs text-neutral-400 mt-0.5 truncate">{{ $g->tempat->paket->nama_paket }}</p>
                        @endif
                    @elseif($g->fasilitas)
                        <p class="text-xs font-medium text-neutral-700 dark:text-neutral-300 truncate">
                            ⭐ {{ $g->fasilitas->nama_fasilitas }}
                        </p>
                        @if ($g->fasilitas->paket)
                            <p class="text-xs text-neutral-400 mt-0.5 truncate">{{ $g->fasilitas->paket->nama_paket }}</p>
                        @endif
                    @else
                        <p class="text-xs text-neutral-400 truncate">Tidak dikaitkan</p>
                    @endif
                    <p class="text-xs text-neutral-400 mt-1">{{ $g->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-neutral-400">Belum ada media di galeri</p>
                <a href="{{ route('admin.gallery.create') }}"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                    Upload Media Pertama
                </a>
            </div>
        @endforelse
    </div>
@endsection
