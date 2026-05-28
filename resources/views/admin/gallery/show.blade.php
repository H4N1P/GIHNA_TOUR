@extends('components.layout.admin')
@section('title', 'Detail Media')
@section('header', 'Detail Media')

@php
    $mediaType = strtolower($gallery->type ?? 'image');
    $mediaUrl = $gallery->path ? asset('storage/' . $gallery->path) : null;
@endphp

@section('content')
    <div class="max-w-2xl">
        <div
            class="bg-admin-card rounded-xl border border-admin-border overflow-hidden">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center gap-3">
                <a href="{{ route('admin.gallery.index') }}"
                    class="p-2 rounded-lg text-admin-muted hover:text-admin-text hover:bg-admin-bg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h3 class="text-lg font-semibold">Detail Media</h3>
            </div>

            {{-- Media --}}
            <div class="bg-admin-bg">
                @if ($mediaUrl && $mediaType === 'video')
                    <video controls preload="metadata" class="mx-auto h-auto max-h-[70vh] w-full max-w-full bg-black object-contain">
                        <source src="{{ $mediaUrl }}">
                        Browser tidak mendukung preview video.
                    </video>
                @elseif ($mediaUrl)
                    <img src="{{ $mediaUrl }}" alt="Gallery"
                        class="mx-auto h-auto max-h-96 w-full max-w-full object-contain">
                @else
                    <div class="flex min-h-48 items-center justify-center p-6 text-sm text-admin-muted">
                        Media tidak tersedia.
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-4 lg:p-6">
                <table class="w-full text-sm">
                    <tr class="border-b border-admin-border">
                        <td class="py-3 pr-4 text-admin-muted w-36">Diunggah</td>
                        <td class="py-3 font-medium">{{ $gallery->created_at ? $gallery->created_at->format('d F Y, H:i') : '-' }}
                        </td>
                    </tr>
                    @if ($gallery->destinasi)
                        <tr class="border-b border-admin-border">
                            <td class="py-3 pr-4 text-admin-muted">Destinasi Wisata</td>
                            <td class="py-3 font-medium">{{ $gallery->destinasi->nama_destinasi }}</td>
                        </tr>
                        @if ($gallery->destinasi->paket)
                            <tr class="border-b border-admin-border">
                                <td class="py-3 pr-4 text-admin-muted">Paket</td>
                                <td class="py-3">{{ $gallery->destinasi->paket->nama_paket }}</td>
                            </tr>
                        @endif
                    @endif
                    @if ($gallery->fasilitas)
                        <tr class="border-b border-admin-border">
                            <td class="py-3 pr-4 text-admin-muted">Fasilitas</td>
                            <td class="py-3 font-medium">{{ $gallery->fasilitas->nama_fasilitas }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="py-3 pr-4 text-admin-muted">Tipe</td>
                        <td class="py-3 font-medium capitalize">{{ $mediaType }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 pr-4 text-admin-muted">Path</td>
                        <td class="py-3 text-xs font-mono text-admin-muted break-all">{{ $gallery->path }}</td>
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
                        Hapus Media
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
