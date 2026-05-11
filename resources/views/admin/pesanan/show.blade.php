@extends('components.layout.admin')
@section('title', 'Invoice ' . $pesanan->invoice)
@section('header', 'Detail Pesanan')

@section('content')
    <div class="max-w-3xl">

        {{-- Action Bar --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.pesanan.index') }}"
                class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Pesanan
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/40 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>

        {{-- ── Invoice Card ── --}}
        <div id="invoice-print"
            class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm overflow-hidden">

            {{-- Header stripe --}}
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-6">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-10 h-10 rounded-lg bg-white p-1.5 flex items-center justify-center">
                                <img src="{{ asset('customer/assets/images/logos/logo.png') }}" class="w-full h-full object-contain" alt="Logo">
                            </div>
                            <div>
                                <h1 class="text-white font-bold text-lg leading-tight">Ghina Tour & Travel</h1>
                                <p class="text-white/70 text-xs">Paket Wisata Terpercaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-white/70 text-xs uppercase tracking-widest mb-1">Invoice</p>
                        <p class="text-white font-bold text-lg font-mono">{{ $pesanan->invoice }}</p>
                        <p class="text-white/70 text-xs mt-1">
                            {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Status badge --}}
            <div
                class="px-8 py-3 bg-neutral-50 dark:bg-neutral-800/50 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                <span class="text-xs text-neutral-500 dark:text-neutral-400">Status Pesanan</span>
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                {{ $pesanan->status === 'selesai'
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    : ($pesanan->status === 'batal'
                        ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                        : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400') }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full
                    {{ $pesanan->status === 'selesai' ? 'bg-green-500' : ($pesanan->status === 'batal' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                    {{ ucfirst($pesanan->status ?? 'pending') }}
                </span>
            </div>

            <div class="px-8 py-6 space-y-6">

                {{-- Billed to / Paket info --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p
                            class="text-xs font-semibold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mb-3">
                            Billed To</p>
                        <p class="font-bold text-neutral-800 dark:text-neutral-100 text-base">{{ $pesanan->nama_pemesan }}
                        </p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">{{ $pesanan->no_hp }}</p>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider mb-3">
                            Tanggal Tour</p>
                        <p class="font-bold text-neutral-800 dark:text-neutral-100 text-base">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_acara)->format('d F Y') }}
                        </p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_acara)->locale('id')->isoFormat('dddd') }}
                        </p>
                    </div>
                </div>

                {{-- Line items table --}}
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-neutral-50 dark:bg-neutral-800">
                                <th class="px-4 py-3 text-left text-xs font-bold text-neutral-500 uppercase tracking-wider">
                                    Deskripsi</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-bold text-neutral-500 uppercase tracking-wider">
                                    Pax</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-bold text-neutral-500 uppercase tracking-wider">
                                    Harga / Pax</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-bold text-neutral-500 uppercase tracking-wider">
                                    Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($pesanan->is_custom)
                                @foreach($pesanan->custom_places ?? [] as $place)
                                    <tr class="border-t border-neutral-100 dark:border-neutral-700">
                                        <td class="px-4 py-4">
                                            <p class="font-semibold text-neutral-800 dark:text-neutral-100">
                                                {{ $place }}
                                            </p>
                                            <p class="text-xs text-amber-600 mt-0.5">Custom Order</p>
                                        </td>
                                        <td class="px-4 py-4 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                                            {{ $pesanan->jumlah_orang }} pax
                                        </td>
                                        <td class="px-4 py-4 text-right text-neutral-700 dark:text-neutral-300">
                                            —
                                        </td>
                                        <td class="px-4 py-4 text-right font-semibold text-neutral-800 dark:text-neutral-100">
                                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!empty($pesanan->custom_fasilitas))
                                    @foreach($pesanan->custom_fasilitas as $fasilitas)
                                        <tr class="border-t border-neutral-100 dark:border-neutral-700">
                                            <td class="px-4 py-4">
                                                <p class="font-semibold text-neutral-800 dark:text-neutral-100">
                                                    {{ $fasilitas['nama_fasilitas'] ?? '' }}
                                                </p>
                                                <p class="text-xs text-green-600 mt-0.5">
                                                    @if(($fasilitas['tipe_fasilitas'] ?? '') === 'konsumsi') 🍽 Konsumsi
                                                    @elseif(($fasilitas['tipe_fasilitas'] ?? '') === 'akomodasi') 🏨 Akomodasi
                                                    @elseif(($fasilitas['tipe_fasilitas'] ?? '') === 'transportasi') 🚌 Transportasi
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-4 py-4 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                                                —
                                            </td>
                                            <td class="px-4 py-4 text-right text-neutral-700 dark:text-neutral-300">
                                                —
                                            </td>
                                            <td class="px-4 py-4 text-right font-semibold text-neutral-800 dark:text-neutral-100">
                                                —
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @else
                                <tr class="border-t border-neutral-100 dark:border-neutral-700">
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-neutral-800 dark:text-neutral-100">
                                            {{ $pesanan->paket->nama_paket ?? 'Paket Wisata' }}
                                        </p>
                                        @if ($pesanan->paket && $pesanan->paket->durasi)
                                            <p class="text-xs text-neutral-400 mt-0.5">Durasi: {{ $pesanan->paket->durasi }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center text-neutral-700 dark:text-neutral-300 font-medium">
                                        {{ $pesanan->jumlah_orang }} pax
                                    </td>
                                    <td class="px-4 py-4 text-right text-neutral-700 dark:text-neutral-300">
                                        @if ($pesanan->paket)
                                            Rp {{ number_format($pesanan->paket->harga_paket, 0, ',', '.') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right font-semibold text-neutral-800 dark:text-neutral-100">
                                        @if ($pesanan->paket)
                                            Rp
                                            {{ number_format($pesanan->paket->harga_paket * $pesanan->jumlah_orang, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Totals --}}
                <div class="flex justify-end">
                    <div class="w-72 space-y-2">
                        @php
                            $subtotal = $pesanan->paket
                                ? $pesanan->paket->harga_paket * $pesanan->jumlah_orang
                                : $pesanan->total_harga;
                            $diskonPct = (float) ($pesanan->diskon ?? 0);
                            $diskonNom = $subtotal * ($diskonPct / 100);
                            $total = $pesanan->total_harga;
                        @endphp

                        <div class="flex justify-between text-sm text-neutral-600 dark:text-neutral-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        @if ($diskonPct > 0)
                            <div class="flex justify-between text-sm text-red-500">
                                <span>Diskon ({{ $diskonPct }}%)</span>
                                <span>- Rp {{ number_format($diskonNom, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div
                            class="border-t border-neutral-200 dark:border-neutral-700 pt-2 flex justify-between items-center">
                            <span class="font-bold text-neutral-800 dark:text-neutral-100">Total</span>
                            <span class="text-xl font-bold text-amber-600 dark:text-amber-400">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas paket (opsional) --}}
                @if ($pesanan->paket && $pesanan->paket->fasilitas && $pesanan->paket->fasilitas->count() > 0)
                    @php $fasGroup = $pesanan->paket->fasilitas->groupBy('tipe_fasilitas'); @endphp
                    <div class="border-t border-neutral-100 dark:border-neutral-800 pt-5">
                        <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider mb-3">Fasilitas Termasuk
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach ($fasGroup as $tipe => $items)
                                @php
                                    $color = match ($tipe) {
                                        'konsumsi'
                                            => 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400',
                                        'akomodasi'
                                            => 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400',
                                        'transportasi'
                                            => 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400',
                                        default
                                            => 'bg-neutral-50 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400',
                                    };
                                @endphp
                                <div class="rounded-lg p-3 {{ $color }}">
                                    <p class="text-xs font-bold uppercase mb-1.5">{{ ucfirst($tipe) }}</p>
                                    <ul class="space-y-0.5">
                                        @foreach ($items as $f)
                                            <li class="text-xs flex items-start gap-1.5">
                                                <span class="mt-0.5">✓</span>
                                                <span>{{ $f->nama_fasilitas }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Footer note --}}
                <div class="border-t border-neutral-100 dark:border-neutral-800 pt-5 text-center">
                    <p class="text-xs text-neutral-400">
                        Terima kasih telah mempercayakan perjalanan Anda kepada <strong>Ghina Tour & Travel</strong>.
                    </p>
                    <p class="text-xs text-neutral-400 mt-1">
                        Diterbitkan: {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            {{-- Danger zone --}}
            <div
                class="px-8 py-4 bg-neutral-50 dark:bg-neutral-800/50 border-t border-neutral-100 dark:border-neutral-800 flex justify-end">
                <form action="{{ route('admin.pesanan.destroy', $pesanan->id) }}" method="POST"
                    data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus pesanan?"
                    data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">
                        Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-print,
            #invoice-print * {
                visibility: visible;
            }

            #invoice-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .bg-gradient-to-r {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection
