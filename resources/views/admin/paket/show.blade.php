@extends('components.layout.admin')
@section('title', 'Detail Paket Tour')
@section('header', 'Detail Paket Tour')

@section('content')
    <div class="max-w-4xl">
        <div
            class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

            {{-- Header --}}
            <div class="p-4 lg:p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.paket.index') }}"
                        class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h3 class="text-lg font-semibold">Detail Paket Tour</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">ID
                            #{{ str_pad($paket->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.paket.edit', $paket->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Paket
                </a>
            </div>

            {{-- Nama + info utama --}}
            <div class="p-4 lg:p-6 border-b border-neutral-100 dark:border-neutral-800">
                <div class="flex items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">{{ $paket->nama_paket }}</h4>
                        <p class="text-sm text-neutral-400 mt-1">Dibuat: {{ $paket->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-5">
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4">
                        <p class="text-xs text-amber-600 dark:text-amber-400 font-semibold uppercase tracking-wider">Harga /
                            Pax</p>
                        <p class="text-lg font-bold text-amber-700 dark:text-amber-300 mt-1">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-4">
                        <p class="text-xs text-neutral-500 font-semibold uppercase tracking-wider">Durasi</p>
                        <p class="text-base font-bold text-neutral-800 dark:text-neutral-100 mt-1">
                            {{ $paket->durasi ?? '-' }}</p>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-4 col-span-2 sm:col-span-1">
                        <p class="text-xs text-neutral-500 font-semibold uppercase tracking-wider">Total Komponen</p>
                        <p class="text-base font-bold text-neutral-800 dark:text-neutral-100 mt-1">
                            {{ $paket->tempats->count() }} Tempat · {{ $paket->fasilitas->count() }} Fasilitas
                        </p>
                    </div>
                </div>
            </div>

            {{-- Rundown --}}
            @if ($paket->rundown)
                <div class="px-4 lg:px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-3">Rundown / Itinerary</p>
                    <div
                        class="bg-neutral-50 dark:bg-neutral-800 rounded-xl p-4 text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">
                        {{ $paket->rundown }}</div>
                </div>
            @endif

            {{-- Note --}}
            @if ($paket->note)
                <div class="px-4 lg:px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-3">Catatan</p>
                    <div
                        class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 text-sm text-amber-800 dark:text-amber-300 leading-relaxed">
                        {{ $paket->note }}</div>
                </div>
            @endif

            {{-- Tempat + Fasilitas --}}
            <div class="px-4 lg:px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-4">Komponen Paket</p>

                @php
                    $fasGroup = $paket->fasilitas->groupBy('tipe_fasilitas');
                    $tipeConfig = [
                        'konsumsi' => [
                            'label' => 'Konsumsi',
                            'bg' => 'bg-green-50 dark:bg-green-900/20',
                            'text' => 'text-green-700 dark:text-green-400',
                            'badge' => 'bg-green-100 dark:bg-green-900/30',
                        ],
                        'akomodasi' => [
                            'label' => 'Akomodasi',
                            'bg' => 'bg-purple-50 dark:bg-purple-900/20',
                            'text' => 'text-purple-700 dark:text-purple-400',
                            'badge' => 'bg-purple-100 dark:bg-purple-900/30',
                        ],
                        'transportasi' => [
                            'label' => 'Transportasi',
                            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
                            'text' => 'text-blue-700 dark:text-blue-400',
                            'badge' => 'bg-blue-100 dark:bg-blue-900/30',
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">

                    {{-- Tempat --}}
                    @if ($paket->tempats->count() > 0)
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-xs font-bold text-amber-700 dark:text-amber-400 uppercase">Tempat
                                    ({{ $paket->tempats->count() }})</p>
                            </div>
                            <ul class="space-y-1">
                                @foreach ($paket->tempats as $t)
                                    <li class="text-sm text-amber-800 dark:text-amber-300 flex items-start gap-1.5">
                                        <span class="mt-1 w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                                        {{ $t->nama_tempat }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Fasilitas grouped --}}
                    @forelse($fasGroup as $tipe => $items)
                        @php $cfg = $tipeConfig[strtolower($tipe)] ?? ['label'=>ucfirst($tipe),'bg'=>'bg-neutral-50 dark:bg-neutral-800','text'=>'text-neutral-600 dark:text-neutral-400','badge'=>'']; @endphp
                        <div class="{{ $cfg['bg'] }} rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <p class="text-xs font-bold {{ $cfg['text'] }} uppercase">{{ $cfg['label'] }}
                                    ({{ $items->count() }})</p>
                            </div>
                            <ul class="space-y-1">
                                @foreach ($items as $f)
                                    <li class="text-sm {{ $cfg['text'] }} flex items-start gap-1.5">
                                        <span class="mt-1">✓</span>
                                        {{ $f->nama_fasilitas }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                    @endforelse

                    @if ($paket->tempats->count() === 0 && $paket->fasilitas->count() === 0)
                        <div class="col-span-full bg-neutral-50 dark:bg-neutral-800 rounded-xl p-6 text-center">
                            <p class="text-neutral-400 text-sm">Belum ada komponen yang ditambahkan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="px-4 lg:px-6 py-4 bg-neutral-50 dark:bg-neutral-800/50 flex items-center justify-between">
                <p class="text-xs text-neutral-400">Diperbarui: {{ $paket->updated_at->format('d M Y, H:i') }}</p>
                <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST"
                    data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus paket?"
                    data-confirm-message="Semua data terkait ikut terhapus dan tidak bisa dikembalikan">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-sm text-red-600 dark:text-red-400 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
