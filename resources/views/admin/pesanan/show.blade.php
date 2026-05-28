@extends('components.layout.admin')
@section('title', 'Invoice ' . $pesanan->invoice)
@section('header', 'Detail Pesanan')

@php
    $isCustom = (bool) $pesanan->is_custom;
    $paket = $pesanan->paket;
    $qty = max((int) ($pesanan->jumlah_orang ?? 1), 1);
    $discountPct = (float) ($pesanan->diskon ?? 0);
    $total = (float) ($pesanan->total_harga ?? 0);

    if (!$isCustom && $paket) {
        $unitPrice = (float) ($paket->harga_paket ?? 0);
        $subtotal = $unitPrice * $qty;
    } else {
        $subtotal = $discountPct > 0 && $discountPct < 100
            ? $total / (1 - ($discountPct / 100))
            : $total;
        $unitPrice = $qty > 0 ? $subtotal / $qty : $subtotal;
    }

    $discountNominal = $subtotal * ($discountPct / 100);
    $status = $pesanan->status ?? 'pending';
    $statusClass = match ($status) {
        'selesai' => 'bg-emerald-400 text-emerald-950',
        'batal' => 'bg-rose-100 text-rose-700',
        default => 'bg-orange-100 text-orange-700',
    };

    $createdDate = \Carbon\Carbon::parse($pesanan->created_at)->format('d F Y');
    $eventDate = $pesanan->tanggal_acara
        ? \Carbon\Carbon::parse($pesanan->tanggal_acara)->format('d F Y')
        : '-';
    $customPlaces = collect($pesanan->custom_places ?? [])->filter();
    $customFacilities = collect($pesanan->custom_fasilitas ?? [])->filter();
@endphp

@section('content')
    <div class="mx-auto max-w-[1120px]">
        <div class="invoice-actions mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('admin.pesanan.index') }}"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-admin-border bg-admin-card text-admin-muted transition-colors hover:text-admin-text"
                aria-label="Kembali ke daftar pesanan">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}"
                    class="inline-flex min-h-11 items-center gap-2 rounded-lg bg-orange-100 px-5 text-sm font-bold text-orange-600 transition hover:bg-orange-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <button type="button" onclick="printInvoice()"
                    class="inline-flex min-h-11 items-center gap-2 rounded-lg bg-orange-500 px-5 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>

        @if ($isCustom)
            <section id="invoice-print"
                class="invoice-sheet invoice-sheet--custom bg-white p-5 text-slate-950 shadow-sm sm:p-6">
                <div class="mb-4 flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h1 class="text-xl font-black leading-tight">Ghinatour Travel</h1>
                        <p class="mt-1 text-xs font-medium text-slate-600">Jl. Contoh Travel No. 123, Jakarta Selatan</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-xl font-black uppercase tracking-wide text-orange-500">Invoice</p>
                        <p class="mt-1 text-xs font-bold text-slate-800">No. INV: {{ $pesanan->invoice }}</p>
                        <p class="text-xs font-semibold text-slate-600">Tanggal: {{ $createdDate }}</p>
                        <span
                            class="mt-1 inline-flex rounded-full px-2.5 py-1 text-[11px] font-bold {{ $statusClass }}">{{ ucfirst($status) }}</span>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-2 text-xs font-black uppercase tracking-wide text-slate-700">Data Pemesan</p>
                        <dl class="grid gap-1.5 text-xs">
                            <div>
                                <dt class="font-bold text-slate-500">Nama Perwakilan</dt>
                                <dd class="font-bold">{{ $pesanan->nama_pemesan }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500">No. HP</dt>
                                <dd class="font-bold">{{ $pesanan->no_hp }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-2 text-xs font-black uppercase tracking-wide text-slate-700">Detail Acara</p>
                        <dl class="grid gap-1.5 text-xs">
                            <div>
                                <dt class="font-bold text-slate-500">Tanggal Acara</dt>
                                <dd class="font-bold">{{ $eventDate }}</dd>
                            </div>
                            <div>
                                <dt class="font-bold text-slate-500">Jumlah Pax</dt>
                                <dd class="font-bold">{{ $qty }} Orang</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="break-inside-avoid">
                        <p class="mb-2 text-xs font-black uppercase tracking-wide text-slate-700">Tempat Tujuan Custom</p>
                        <ul class="space-y-1 text-xs">
                            @forelse ($customPlaces as $place)
                                <li class="flex items-start gap-2">
                                    <span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full bg-slate-400"></span>
                                    <span>{{ $place }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500">Belum ada tujuan custom.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="break-inside-avoid">
                        <p class="mb-2 text-xs font-black uppercase tracking-wide text-slate-700">Fasilitas Termasuk</p>
                        <ul class="divide-y divide-slate-100 text-xs">
                            @forelse ($customFacilities as $facility)
                                <li class="flex items-center justify-between gap-3 py-1">
                                    <span>{{ $facility['nama_fasilitas'] ?? '-' }}</span>
                                    @if (!empty($facility['tipe_fasilitas']))
                                        <span class="rounded border border-slate-200 px-2 py-0.5 text-[10px] font-bold capitalize text-slate-600">
                                            {{ $facility['tipe_fasilitas'] }}
                                        </span>
                                    @endif
                                </li>
                            @empty
                                <li class="text-slate-500">Belum ada fasilitas tambahan.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 font-black uppercase tracking-wide text-slate-700">
                                <th class="py-2 text-left">Deskripsi</th>
                                <th class="py-2 text-right">Harga per Pax</th>
                                <th class="py-2 text-center">Jumlah Pax</th>
                                <th class="py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-100">
                                <td class="py-3 font-medium">
                                    Paket Custom Travel
                                    @if ($customPlaces->isNotEmpty())
                                        <span class="font-normal text-slate-600">({{ $customPlaces->join(' - ') }})</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                                <td class="py-3 text-center">{{ $qty }}</td>
                                <td class="py-3 text-right font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-end">
                    <div class="w-full max-w-[300px] space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($discountPct > 0)
                            <div class="flex justify-between">
                                <span>Diskon ({{ rtrim(rtrim(number_format($discountPct, 2, ',', '.'), '0'), ',') }}%)</span>
                                <span>- Rp {{ number_format($discountNominal, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between border-t border-slate-200 pt-2 font-black">
                            <span>Total Akhir</span>
                            <span class="text-base">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section id="invoice-print" class="invoice-sheet overflow-hidden bg-white text-slate-950 shadow-sm">
                <div class="bg-[#ff8a4c] px-8 py-8 text-white sm:px-12">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h1 class="text-xl font-black leading-tight">GhinaTour Travel</h1>
                            <p class="mt-1 text-xs font-semibold">Siap Menemani Perjalanan Nyaman Mu</p>
                            <div class="mt-5 space-y-1 text-xs leading-relaxed text-white/90">
                                <p>Jl. Di Panjaitan, Purwokerto, Banyumas</p>
                                <p>Jawa Tengah, Indonesia</p>
                                <p>ghinatourtravel@gmail.com</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-4xl font-black uppercase text-orange-700/45">Invoice</p>
                            <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-black {{ $statusClass }}">
                                Status: {{ ucfirst($status) }}
                            </span>
                            <p class="mt-4 text-xs font-semibold text-white/90">Invoice No: {{ $pesanan->invoice }}</p>
                            <p class="text-xs font-semibold text-white/90">Tanggal: {{ $createdDate }}</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-10 sm:px-12">
                    <div class="grid gap-8 md:grid-cols-[1fr_320px] md:items-start">
                        <div class="md:pl-24">
                            <p class="mb-3 text-xs font-black uppercase tracking-wide text-teal-700">Perwakilan Trip</p>
                            <p class="text-lg font-black">{{ $pesanan->nama_pemesan }}</p>
                            <p class="mt-1 text-sm">{{ $pesanan->no_hp }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-100 p-6">
                            <p class="mb-3 text-xs font-black uppercase tracking-wide text-teal-700">Detail Paket</p>
                            <p class="text-lg font-black">{{ $paket->nama_paket ?? 'Paket Wisata' }}</p>
                            <p class="mt-3 text-xs font-semibold text-slate-600">
                                {{ $paket->lokasi ?? '-' }} | {{ $paket->durasi ?? '-' }} | {{ $qty }} Peserta
                            </p>
                        </div>
                    </div>

                    <div class="mt-12 overflow-x-auto">
                        <table class="w-full min-w-[620px] text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-black uppercase tracking-wide text-slate-700">
                                    <th class="py-4 text-left md:pl-24">Deskripsi Paket</th>
                                    <th class="py-4 text-right">Detail Paket</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="py-5 font-bold md:pl-24">Nama Paket</td>
                                    <td class="py-5 text-right">{{ $paket->nama_paket ?? 'Paket Wisata' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-5 font-bold md:pl-24">Durasi</td>
                                    <td class="py-5 text-right">{{ $paket->durasi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="py-5 font-bold md:pl-24">Harga / Pax</td>
                                    <td class="py-5 text-right">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-5 font-bold md:pl-24">Jumlah Pax</td>
                                    <td class="py-5 text-right">{{ $qty }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 flex justify-end">
                        <div class="w-full max-w-[340px] space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if ($discountPct > 0)
                                <div class="flex justify-between">
                                    <span>Diskon ({{ rtrim(rtrim(number_format($discountPct, 2, ',', '.'), '0'), ',') }}%)</span>
                                    <span>- Rp {{ number_format($discountNominal, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between pt-2 font-black">
                                <span class="uppercase tracking-wide">Harga Total</span>
                                <span class="text-2xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <style>
        :root {
            --invoice-print-scale: 1;
            --invoice-print-width: 194mm;
            --invoice-print-max-height: 281mm;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            * {
                print-color-adjust: exact !important;
                -webkit-print-color-adjust: exact !important;
            }

            html,
            body {
                width: 194mm !important;
                height: 281mm !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            body.printing-invoice > :not(#invoice-print-clone) {
                display: none !important;
            }

            #invoice-print-clone,
            #invoice-print-clone * {
                visibility: visible !important;
            }

            #invoice-print-clone {
                display: block !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: var(--invoice-print-width) !important;
                height: var(--invoice-print-max-height) !important;
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: hidden !important;
                zoom: var(--invoice-print-scale);
                page-break-before: avoid !important;
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
            }

            @supports not (zoom: 1) {
                #invoice-print-clone {
                    transform: scale(var(--invoice-print-scale)) !important;
                    transform-origin: top left !important;
                }
            }

            #invoice-print-clone.invoice-sheet--custom {
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                padding: 0 !important;
                font-size: 10px !important;
                line-height: 1.25 !important;
            }

            #invoice-print-clone.invoice-sheet--custom table {
                font-size: 10px !important;
            }

            #invoice-print-clone.invoice-sheet--custom .break-inside-avoid,
            #invoice-print-clone.invoice-sheet--custom table,
            #invoice-print-clone.invoice-sheet--custom tr {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }

            .invoice-actions,
            .admin-sidebar,
            .admin-topbar,
            .admin-modal,
            .admin-backdrop,
            .chatbot-trigger,
            .chatbot-container,
            .wa-float {
                display: none !important;
            }
        }
    </style>

    <script>
        function prepareInvoicePrint() {
            const invoice = document.getElementById('invoice-print');
            if (!invoice) return;

            document.documentElement.style.setProperty('--invoice-print-scale', '1');
            document.documentElement.style.setProperty('--invoice-print-width', '194mm');
            document.documentElement.style.setProperty('--invoice-print-max-height', '281mm');
            document.getElementById('invoice-print-clone')?.remove();
            document.getElementById('invoice-print-probe')?.remove();

            const pxPerMm = 96 / 25.4;
            const printableWidth = 194 * pxPerMm;
            const printableHeight = 281 * pxPerMm;

            const probe = invoice.cloneNode(true);
            probe.id = 'invoice-print-probe';
            probe.style.position = 'fixed';
            probe.style.left = '-10000px';
            probe.style.top = '0';
            probe.style.width = `${printableWidth}px`;
            probe.style.maxWidth = 'none';
            probe.style.visibility = 'hidden';
            probe.style.pointerEvents = 'none';
            document.body.appendChild(probe);

            const contentHeight = Math.max(probe.scrollHeight, probe.offsetHeight, 1);
            probe.remove();

            const scale = Math.min(1, printableHeight / contentHeight);

            document.documentElement.style.setProperty('--invoice-print-scale', scale.toFixed(4));
            document.documentElement.style.setProperty('--invoice-print-width', `${(194 / scale).toFixed(3)}mm`);
            document.documentElement.style.setProperty('--invoice-print-max-height', `${(281 / scale).toFixed(3)}mm`);

            const clone = invoice.cloneNode(true);
            clone.id = 'invoice-print-clone';
            clone.setAttribute('aria-hidden', 'true');
            document.body.appendChild(clone);
            document.body.classList.add('printing-invoice');
        }

        function resetInvoicePrint() {
            document.documentElement.style.setProperty('--invoice-print-scale', '1');
            document.documentElement.style.setProperty('--invoice-print-width', '194mm');
            document.documentElement.style.setProperty('--invoice-print-max-height', '281mm');
            document.body.classList.remove('printing-invoice');
            document.getElementById('invoice-print-clone')?.remove();
            document.getElementById('invoice-print-probe')?.remove();
        }

        function printInvoice() {
            prepareInvoicePrint();
            window.print();
        }

        window.addEventListener('beforeprint', prepareInvoicePrint);
        window.addEventListener('afterprint', resetInvoicePrint);
    </script>
@endsection
