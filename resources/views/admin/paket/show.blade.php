@extends('components.layout.admin')
@section('title', 'Detail Paket Tour')
@section('header', 'Detail Paket Tour')

@section('content')
    <div class="max-w-4xl">
        <div class="overflow-hidden rounded-xl border border-admin-border bg-admin-card">
            <div class="flex items-center justify-between border-b border-admin-border p-4 lg:p-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.paket.index') }}"
                        class="rounded-lg p-2 text-admin-muted transition-colors hover:bg-admin-bg hover:text-admin-text">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h3 class="text-lg font-semibold text-admin-text">Detail Paket Tour</h3>
                        <p class="text-sm text-admin-muted">ID #{{ str_pad($paket->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <a href="{{ route('admin.paket.edit', $paket->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-admin-bg px-4 py-2 text-sm font-medium text-admin-text transition-colors hover:bg-admin-border">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Paket
                </a>
            </div>

            <div class="border-b border-admin-border p-4 lg:p-6">
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl border border-admin-border bg-admin-bg">
                        @if ($paket->image)
                            <img src="{{ asset('storage/' . $paket->image) }}" class="h-full w-full rounded-xl object-cover"
                                alt="Cover">
                        @else
                            <svg class="h-7 w-7 text-admin-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-xl font-bold text-admin-text">{{ $paket->nama_paket }}</h4>
                        <p class="mt-1 text-sm text-admin-muted">Dibuat: {{ $paket->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-admin-border bg-admin-bg p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-admin-muted">Harga / Pax</p>
                        <p class="mt-1 text-lg font-bold text-admin-text">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-admin-border bg-admin-bg p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-admin-muted">Durasi</p>
                        <p class="mt-1 text-base font-bold text-admin-text">{{ $paket->durasi ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 rounded-xl border border-admin-border bg-admin-bg p-4 sm:col-span-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-admin-muted">Total Komponen</p>
                        <p class="mt-1 text-base font-bold text-admin-text">
                            {{ $paket->destinasis->count() }} Destinasi / {{ $paket->fasilitas->count() }} Fasilitas
                        </p>
                    </div>
                </div>
            </div>

            @if ($paket->rundown)
                <div class="border-b border-admin-border px-4 py-5 lg:px-6">
                    <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-admin-muted">Rundown / Itinerary</p>
                    <div class="whitespace-pre-line rounded-xl border border-admin-border bg-admin-bg p-4 text-sm leading-relaxed text-admin-text">
                        {{ $paket->rundown }}
                    </div>
                </div>
            @endif

            @if ($paket->note)
                <div class="border-b border-admin-border px-4 py-5 lg:px-6">
                    <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-admin-muted">Catatan</p>
                    <div class="rounded-xl border border-admin-border bg-admin-bg p-4 text-sm leading-relaxed text-admin-text">
                        {{ $paket->note }}
                    </div>
                </div>
            @endif

            <div class="border-b border-admin-border px-4 py-5 lg:px-6">
                <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-admin-muted">Komponen Paket</p>

                @php
                    $fasGroup = $paket->fasilitas->groupBy('tipe_fasilitas');
                @endphp

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @if ($paket->destinasis->count() > 0)
                        <div class="rounded-xl border border-admin-border bg-admin-bg p-4">
                            <div class="mb-3 flex items-center gap-2">
                                <svg class="h-4 w-4 text-admin-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-xs font-bold uppercase text-admin-muted">
                                    Destinasi ({{ $paket->destinasis->count() }})
                                </p>
                            </div>
                            <ul class="space-y-2">
                                @foreach ($paket->destinasis as $t)
                                    <li class="flex items-center gap-2 text-sm text-admin-text">
                                        @if ($t->image)
                                            <img src="{{ asset('storage/' . $t->image) }}" class="h-6 w-6 rounded object-cover"
                                                alt="">
                                        @else
                                            <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full bg-admin-muted"></span>
                                        @endif
                                        {{ $t->nama_destinasi }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @forelse ($fasGroup as $tipe => $items)
                        @php
                            $tipeLabel = $tipe ? ucfirst((string) $tipe) : 'Lainnya';
                        @endphp
                        <div class="rounded-xl border border-admin-border bg-admin-bg p-4">
                            <div class="mb-3 flex items-center gap-2">
                                <p class="text-xs font-bold uppercase text-admin-muted">{{ $tipeLabel }} ({{ $items->count() }})</p>
                            </div>
                            <ul class="space-y-2">
                                @foreach ($items as $f)
                                    <li class="flex items-center gap-2 text-sm text-admin-text">
                                        @if ($f->image)
                                            <img src="{{ asset('storage/' . $f->image) }}" class="h-6 w-6 rounded object-cover"
                                                alt="">
                                        @else
                                            <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full bg-admin-muted"></span>
                                        @endif
                                        {{ $f->nama_fasilitas }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                    @endforelse

                    @if ($paket->destinasis->count() === 0 && $paket->fasilitas->count() === 0)
                        <div class="col-span-full rounded-xl border border-admin-border bg-admin-bg p-6 text-center">
                            <p class="text-sm text-admin-muted">Belum ada komponen yang ditambahkan</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between bg-admin-bg/50 px-4 py-4 lg:px-6">
                <p class="text-xs text-admin-muted">Diperbarui: {{ $paket->updated_at->format('d M Y, H:i') }}</p>
                <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST" data-confirm="delete"
                    data-confirm-title="Apakah anda yakin menghapus paket?"
                    data-confirm-message="Semua data terkait ikut terhapus dan tidak bisa dikembalikan">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-sm text-red-600 hover:underline dark:text-red-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Paket
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
