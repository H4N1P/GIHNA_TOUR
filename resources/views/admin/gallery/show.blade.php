@extends('components.layout.admin')
@section('title', 'Detail Foto')
@section('header', 'Detail Foto')

@section('content')
    <div class="max-w-2xl">
        <div
            class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
            <div class="p-4 lg:p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center gap-3">
                <a href="{{ route('admin.gallery.index') }}"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h3 class="text-lg font-semibold">Detail Foto</h3>
            </div>

            {{-- Foto --}}
            <div class="bg-neutral-100 dark:bg-neutral-800">
                <img src="{{ asset('storage/' . $gallery->path) }}" alt="Gallery"
                    class="w-full max-h-96 object-contain mx-auto">
            </div>

            {{-- Info --}}
            <div class="p-4 lg:p-6">
                <table class="w-full text-sm">
                    <tr class="border-b border-neutral-100 dark:border-neutral-800">
                        <td class="py-3 pr-4 text-neutral-500 w-36">Diunggah</td>
                        <td class="py-3 font-medium">{{ $gallery->created_at ? $gallery->created_at->format('d F Y, H:i') : '-' }}
                        </td>
                    </tr>
                    @if ($gallery->tempat)
                        <tr class="border-b border-neutral-100 dark:border-neutral-800">
                            <td class="py-3 pr-4 text-neutral-500">Tempat Wisata</td>
                            <td class="py-3 font-medium">{{ $gallery->tempat->nama_tempat }}</td>
                        </tr>
                        @if ($gallery->tempat->paket)
                            <tr class="border-b border-neutral-100 dark:border-neutral-800">
                                <td class="py-3 pr-4 text-neutral-500">Paket</td>
                                <td class="py-3">{{ $gallery->tempat->paket->nama_paket }}</td>
                            </tr>
                        @endif
                    @endif
                    @if ($gallery->fasilitas)
                        <tr class="border-b border-neutral-100 dark:border-neutral-800">
                            <td class="py-3 pr-4 text-neutral-500">Fasilitas</td>
                            <td class="py-3 font-medium">{{ $gallery->fasilitas->nama_fasilitas }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="py-3 pr-4 text-neutral-500">Path</td>
                        <td class="py-3 text-xs font-mono text-neutral-500 break-all">{{ $gallery->path }}</td>
                    </tr>
                </table>
            </div>

            <div class="px-4 lg:px-6 pb-6 flex justify-end">
                <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                    data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus media?"
                    data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                        Hapus Foto
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
