@extends('components.layout.customer')

@section('title', $paket->nama_paket . ' — Ghina Tour Travel')

@section('extra_styles')
    <style>
        .detail-hero {
            background: var(--bg-section);
        }

        .placeholder-panel {
            background: var(--bg-section);
            border: 1px solid var(--border);
        }

        .fas-box,
        .harga-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
        }

        .fas-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 6px 0;
            border-bottom: 1px solid var(--border);
        }

        .fas-item:last-child {
            border: none;
        }

        .rundown-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
        }

        .tempat-card {
            position: relative;
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg-section);
            border: 1px solid var(--border);
        }

        .tempat-card__label {
            position: absolute;
            inset: auto 0 0 0;
            padding: 12px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 100%);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }

        .placeholder-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #9ca3af;
        }

        .placeholder-icon svg {
            width: 44px;
            height: 44px;
        }
    </style>
@endsection

@section('content')
    <!-- HERO / HEADER PAKET -->
    <div class="detail-hero relative mt-[72px] h-[320px] w-full overflow-hidden sm:h-[380px] lg:h-[420px]">
        @if ($paket->image)
            <img src="{{ Str::startsWith($paket->image, 'http') ? $paket->image : asset('storage/' . $paket->image) }}"
                alt="{{ $paket->nama_paket }}" class="absolute inset-0 h-full w-full max-w-full object-cover" />
            <div class="absolute inset-0" style="background:rgba(0,0,0,.45);"></div>
        @else
            <div class="placeholder-icon absolute inset-0">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM8.5 11.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5Z" />
                </svg>
            </div>
            <div class="absolute inset-0" style="background:rgba(255,255,255,.35);"></div>
        @endif
        <div class="absolute inset-0 flex items-center justify-center flex-col gap-2 px-4 text-center">
            <h1 class="text-3xl font-bold sm:text-[38px] {{ $paket->image ? 'text-white' : 't' }}">
                {{ $paket->nama_paket }}
            </h1>
            <p class="{{ $paket->image ? 'text-gray-200' : 'tm' }} text-base">Paket Wisata</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-14">

        <!-- Destinasi Wisata Images -->
        @if ($paket->destinasis && $paket->destinasis->count() > 0)
            <div class="mb-10">
                <h2 class="text-[22px] font-bold t mb-4">Destinasi Wisata</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
                    @foreach ($paket->destinasis as $tempat)
                        @php
                            $destSrc = $tempat->image
                                ? (Str::startsWith($tempat->image, 'http') ? $tempat->image : asset('storage/' . $tempat->image))
                                : null;
                        @endphp
                        <div class="tempat-card cursor-pointer group"
                            @if($destSrc) onclick="openLightbox('{{ $destSrc }}', '{{ $tempat->nama_destinasi }}')" @endif>
                            @if ($tempat->image)
                                <img src="{{ $destSrc }}"
                                    alt="{{ $tempat->nama_destinasi }}" class="absolute inset-0 h-full w-full max-w-full object-cover" loading="lazy" />
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                            @else
                                <div class="placeholder-icon">
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="tempat-card__label">{{ $tempat->nama_destinasi }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Description -->
        @if ($paket->note)
            <div class="mb-10">
                <h2 class="text-[22px] font-bold t mb-4">Deskripsi Paket</h2>
                <div class="p-6 rounded-2xl" style="background:var(--bg-card);border:1px solid var(--border);">
                    <p class="tm leading-7">{{ $paket->note }}</p>
                </div>
            </div>
        @endif

        <!-- Rundown Detail (visible to admin only) -->
        @auth
            @if ($paket->rundowns && $paket->rundowns->count() > 0)
                <div class="mb-10">
                    <h2 class="text-[22px] font-bold t mb-4">Rundown Perjalanan</h2>
                    <div class="space-y-4">
                        @foreach ($paket->rundowns as $index => $rundown)
                            <div class="rundown-card">
                                <div class="flex items-start gap-4">
                                    <span
                                        class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-black font-bold text-sm"
                                        style="background:var(--gold);">{{ $index + 1 }}</span>
                                    <div class="flex-1">
                                        <p class="font-semibold text-[15px]" style="color:var(--gold-dark);">
                                            {{ $rundown->waktu }}</p>
                                        <h4 class="font-bold text-[16px] t mt-1 mb-2">{{ $rundown->acara }}</h4>
                                        @if ($rundown->deskripsi)
                                            <p class="tm text-sm leading-7">{{ $rundown->deskripsi }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endauth

        <!-- Fasilitas + Harga -->
        <div class="flex flex-col gap-8 lg:flex-row">

            <!-- Fasilitas -->
            <div class="fas-box flex-1 rounded-2xl p-5 sm:p-7">
                <h2 class="text-[22px] font-bold t mb-5">Fasilitas</h2>

                @php
                    $transportasis = $paket->fasilitas
                        ? $paket->fasilitas->where('tipe_fasilitas', 'transportasi')
                        : collect();
                    $akomodasis = $paket->fasilitas
                        ? $paket->fasilitas->where('tipe_fasilitas', 'akomodasi')
                        : collect();
                    $konsumsis = $paket->fasilitas ? $paket->fasilitas->where('tipe_fasilitas', 'konsumsi') : collect();
                @endphp

                <div class="mb-4">
                    <p class="font-semibold t mb-2 text-[15px]">a. Transportasi</p>
                    <div class="space-y-1 ml-1">
                        @forelse ($transportasis as $transportasi)
                            <div class="fas-item flex items-center gap-2">
                                @if($transportasi->image)
                                    <button type="button" class="flex min-h-11 min-w-11 items-center justify-center rounded hover:ring-2 hover:ring-amber-400" onclick="openLightbox('{{ asset('storage/' . $transportasi->image) }}', '{{ $transportasi->nama_fasilitas }}')">
                                        <img src="{{ asset('storage/' . $transportasi->image) }}" class="h-5 w-5 max-w-full rounded object-cover" alt="{{ $transportasi->nama_fasilitas }}" loading="lazy" />
                                    </button>
                                @else
                                    <span class="tm text-sm">–</span>
                                @endif
                                <span class="tm text-sm">{{ $transportasi->nama_fasilitas }}</span>
                            </div>
                        @empty
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">Bus Pariwisata</span></div>
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">AC (Air Conditioner)</span></div>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold t mb-2 text-[15px]">b. Akomodasi</p>
                    <div class="space-y-1 ml-1">
                        @forelse ($akomodasis as $akomodasi)
                            <div class="fas-item flex items-center gap-2">
                                @if($akomodasi->image)
                                    <button type="button" class="flex min-h-11 min-w-11 items-center justify-center rounded hover:ring-2 hover:ring-amber-400" onclick="openLightbox('{{ asset('storage/' . $akomodasi->image) }}', '{{ $akomodasi->nama_fasilitas }}')">
                                        <img src="{{ asset('storage/' . $akomodasi->image) }}" class="h-5 w-5 max-w-full rounded object-cover" alt="{{ $akomodasi->nama_fasilitas }}" loading="lazy" />
                                    </button>
                                @else
                                    <span class="tm text-sm">–</span>
                                @endif
                                <span class="tm text-sm">{{ $akomodasi->nama_fasilitas }}</span>
                            </div>
                        @empty
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">Tour Leader</span></div>
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">Tiket Masuk Objek Wisata</span></div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <p class="font-semibold t mb-2 text-[15px]">c. Konsumsi</p>
                    <div class="space-y-1 ml-1">
                        @forelse ($konsumsis as $konsumsi)
                            <div class="fas-item flex items-center gap-2">
                                @if($konsumsi->image)
                                    <button type="button" class="flex min-h-11 min-w-11 items-center justify-center rounded hover:ring-2 hover:ring-amber-400" onclick="openLightbox('{{ asset('storage/' . $konsumsi->image) }}', '{{ $konsumsi->nama_fasilitas }}')">
                                        <img src="{{ asset('storage/' . $konsumsi->image) }}" class="h-5 w-5 max-w-full rounded object-cover" alt="{{ $konsumsi->nama_fasilitas }}" loading="lazy" />
                                    </button>
                                @else
                                    <span class="tm text-sm">–</span>
                                @endif
                                <span class="tm text-sm">{{ $konsumsi->nama_fasilitas }}</span>
                            </div>
                        @empty
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">Makan 2x</span></div>
                            <div class="fas-item"><span class="tm text-sm">–</span><span class="tm text-sm">Air Mineral</span></div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Harga & CTA -->
            <div class="w-full lg:w-[300px] flex-shrink-0 space-y-4">
                <div class="harga-box rounded-2xl p-6 space-y-3">
                    <p class="tm text-sm">Harga Paket Tour</p>
                    <p class="text-[26px] font-bold t">
                        Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}<span
                            class="text-base font-normal tm">/pax</span>
                    </p>
                    <p class="text-xs font-bold" style="color:#dc2626;">NB : HARGA SEWAKTU WAKTU BISA BERUBAH</p>

                    <hr style="border-color:var(--border);" />

                    <div class="space-y-2 text-sm tm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--gold);" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            <span>{{ $paket->durasi ?? '1 Hari' }}</span>
                        </div>
                    </div>
                </div>

                <a href="https://wa.me/{{ preg_replace('/\D/', '', $companyProfile->whatsapp ?? '6281390162558') }}?text=Halo%20Ghina%20Tour%20Travel,%20saya%20tertarik%20dengan%20paket%20{{ urlencode($paket->nama_paket) }}."
                    target="_blank" class="btn btn-gold w-full justify-center text-[15px] py-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Pesan via WhatsApp
                </a>
                <a href="{{ route('packages') }}" class="btn w-full justify-center text-[14px] py-3"
                    style="border:1px solid var(--border);background:transparent;color:var(--text);">
                    ← Kembali ke Semua Paket
                </a>
            </div>
        </div>
    </main>
@endsection
