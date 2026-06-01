@extends('components.layout.customer')

@section('title', 'Ghina Tour Travel - Serving With Love')

@section('content')
    <section id="beranda" class="relative min-h-[560px] w-full overflow-hidden sm:min-h-[620px] lg:min-h-[660px]">
        <div class="absolute inset-0 z-10" style="background:var(--hero-overlay);"></div>
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('customer/assets/videos/hero-video.mp4') }}" type="video/mp4">
        </video>

        <div
            class="relative z-20 mx-auto grid min-h-[560px] max-w-7xl items-center px-4 pt-24 sm:min-h-[620px] sm:px-6 lg:min-h-[660px] lg:px-14">
            <div class="fade-in">
                <h1 class="max-w-[820px] text-4xl font-extrabold leading-tight text-white sm:text-[42px] lg:text-[58px]">
                    Temukan Pengalaman Wisata Terbaik Bersama Kami
                </h1>
                <p class="mt-5 max-w-[620px] text-base leading-7 text-gray-200 sm:text-[17px] sm:leading-8">
                    Jelajahi berbagai destinasi menarik dengan paket open trip yang mudah, terjangkau, dan menyenangkan.
                </p>
                <form action="{{ route('packages') }}" method="GET" class="hero-search mt-9">
                    <input type="text" name="q" placeholder="Search by Paket or Destinasi ...">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>
    </section>

    <div class="relative z-20 mx-auto -mt-16 max-w-7xl px-4 sm:px-6 lg:px-14">
        <div class="stats-bar grid grid-cols-1 gap-5 px-5 py-6 sm:grid-cols-2 sm:px-8 lg:grid-cols-4 lg:gap-0 lg:px-12">
            <div class="flex items-center gap-4 lg:border-r lg:border-[var(--border)]">
                <div class="flex h-[58px] w-[58px] items-center justify-center rounded-full bg-[var(--gold)] text-black">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 21V9l9-6 9 6v12h-6v-7H9v7H3Z" />
                    </svg>
                </div>
                <div>
                    {{-- <h2 class="text-[26px] font-extrabold t">{{ $pakets->count() }}+</h2> --}}
                    <h2 class="text-[26px] font-extrabold t">10+</h2>
                    <p class="tm text-sm">Paket Tersedia</p>
                </div>
            </div>
            <div class="flex items-center gap-4 lg:border-r lg:border-[var(--border)] lg:pl-10">
                <div class="flex h-[58px] w-[58px] items-center justify-center rounded-full bg-[var(--gold)] text-black">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M16 11a4 4 0 1 0-3.99-4A4 4 0 0 0 16 11Zm-8 0a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-3.31 0-6 1.57-6 3.5V19h12v-2.5C14 14.57 11.31 13 8 13Zm8 0c-.42 0-.83.03-1.22.08A4.23 4.23 0 0 1 16 16.5V19h6v-2.5c0-1.93-2.69-3.5-6-3.5Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-[26px] font-extrabold t">40+</h2>
                    <p class="tm text-sm">Review Terpercaya</p>
                </div>
            </div>
            <div class="flex items-center gap-4 lg:border-r lg:border-[var(--border)] lg:pl-10">
                <div class="flex h-[58px] w-[58px] items-center justify-center rounded-full bg-[var(--gold)] text-black">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-4Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-[26px] font-extrabold t">99%</h2>
                    <p class="tm text-sm">Aman</p>
                </div>
            </div>
            <div class="flex items-center gap-4 lg:pl-10">
                <div class="flex h-[58px] w-[58px] items-center justify-center rounded-full bg-[var(--gold)] text-black">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm6.93 9h-3.07a15.8 15.8 0 0 0-1.1-5A8.03 8.03 0 0 1 18.93 11ZM12 4.04A13.6 13.6 0 0 1 13.82 11h-3.64A13.6 13.6 0 0 1 12 4.04ZM4.26 13h3.88c.18 1.77.65 3.48 1.1 5a8.03 8.03 0 0 1-4.98-5Zm3.88-2H4.26a8.03 8.03 0 0 1 4.98-5 15.8 15.8 0 0 0-1.1 5ZM12 19.96A13.6 13.6 0 0 1 10.18 13h3.64A13.6 13.6 0 0 1 12 19.96ZM14.76 18a15.8 15.8 0 0 0 1.1-5h3.07a8.03 8.03 0 0 1-4.17 5Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-[26px] font-extrabold t">30++</h2>
                    <p class="tm text-sm">Destinasi</p>
                </div>
            </div>
        </div>
    </div>

    <section id="tentang" class="sec-bg pt-20 pb-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1.1fr_.9fr] lg:gap-14 lg:px-14">
            <div class="fade-in">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[var(--orange)]">Tentang Kami</span>
                <h2 class="mt-2 max-w-[560px] text-3xl font-extrabold leading-tight t">
                    Biro Perjalanan Wisata Terpercaya Dari Purwokerto
                </h2>
                <p class="tm mt-7 max-w-[620px] text-[16px] leading-8">
                    PT Ghina Tour Travel adalah biro perjalanan wisata yang selalu mengerti dan mengutamakan kebutuhan
                    konsumen. Hadir sejak <strong class="t">20 April 2010</strong>, kami melayani perjalanan rombongan
                    dengan harga fleksibel sesuai anggaran Anda.
                </p>
                <p class="tm mt-6 max-w-[620px] text-[16px] leading-8">
                    Tahun 2024 kami rebranding dari Dira Wisata menjadi <strong class="t">PT Ghina Tour
                        Travel</strong>:
                    <strong class="text-[var(--gold-dark)]">Terpercaya, Fleksibel & Fun.</strong>
                </p>
                <div class="visi-card mt-6 max-w-[520px] rounded-2xl p-5 sm:p-6">
                    <div class="flex gap-4">
                        <span
                            class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[var(--gold)] font-extrabold text-black">V</span>
                        <div>
                            <h3 class="font-extrabold t">Visi</h3>
                            <p class="tm mt-1 leading-7">Menjadi perusahaan tour travel pilihan konsumen dengan layanan unik
                                dan berkesan di Indonesia.</p>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <span
                            class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[var(--gold)] font-extrabold text-black">M</span>
                        <div>
                            <h3 class="font-extrabold t">Misi</h3>
                            <p class="tm mt-1 leading-7">Menjaga hubungan jangka panjang dengan pelanggan serta menyediakan
                                pelayanan terbaik di bidang pariwisata.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fade-in space-y-6 lg:pt-12">
                <div class="svc-card flex flex-col gap-4 rounded-2xl p-5 sm:flex-row sm:items-center sm:gap-5 sm:p-6">
                    <span
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[var(--gold)] text-black">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-xl font-extrabold t">Tour Inbound & Outbound</h3>
                        <p class="tm mt-1 text-lg">Wisata domestik & mancanegara untuk rombongan</p>
                    </div>
                </div>
                <div class="svc-card flex flex-col gap-4 rounded-2xl p-5 sm:flex-row sm:items-center sm:gap-5 sm:p-6">
                    <span
                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[var(--gold)] text-black">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18 6H3a2 2 0 0 0-2 2v8h2a3 3 0 1 0 6 0h6a3 3 0 1 0 6 0h2v-5l-5-5ZM6 17.5A1.5 1.5 0 1 1 6 14a1.5 1.5 0 0 1 0 3.5Zm12 0a1.5 1.5 0 1 1 0-3.5 1.5 1.5 0 0 1 0 3.5ZM18 11V8l3 3h-3Z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="text-xl font-extrabold t">Sewa Bus Pariwisata</h3>
                        <p class="tm mt-1 text-lg">Bus AC, audio, reclining seat & nyaman</p>
                    </div>
                </div>
                <div class="rounded-2xl border border-[var(--gold-dark)] bg-[var(--gold)] p-6 text-black">
                    <h3 class="text-2xl font-extrabold">Sudah Melayani 48+ Institusi</h3>
                    <p class="mt-1 text-lg text-black/65">Sekolah, BUMDES, instansi pemerintah & swasta se-Banyumas</p>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="bg-[#f8fafc] py-20 dark:bg-[var(--bg)]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-14">
            <div class="mb-8 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end sm:gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold t sm:text-[32px]">Paket</h2>
                    <p class="tm mt-1 text-lg">Wujudkan Destinasi Tempat Impianmu</p>
                </div>
                <a href="{{ route('packages') }}" class="btn btn-gold w-full sm:w-auto">Lihat Semua Paket</a>
            </div>

            <div class="paket-slider">
                {{-- Prev --}}
                <button type="button" class="paket-slider__btn paket-slider__btn--prev" id="paketPrev"
                    aria-label="Sebelumnya">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Track --}}
                <div class="paket-slider__track" id="paketTrack">
                    @forelse($pakets as $paket)
                        @include('components.customer.package-card', ['paket' => $paket])
                    @empty
                        <p class="tm col-span-full py-8 text-center">Tidak ada paket wisata yang tersedia saat ini.</p>
                    @endforelse
                </div>

                {{-- Next --}}
                <button type="button" class="paket-slider__btn paket-slider__btn--next" id="paketNext"
                    aria-label="Berikutnya">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const track = document.getElementById('paketTrack');
                const prev = document.getElementById('paketPrev');
                const next = document.getElementById('paketNext');
                if (!track) return;

                function scrollAmount() {
                    const card = track.querySelector('.package-card');
                    return card ? card.offsetWidth + 24 : 300;
                }

                prev?.addEventListener('click', () => track.scrollBy({
                    left: -scrollAmount(),
                    behavior: 'smooth'
                }));
                next?.addEventListener('click', () => track.scrollBy({
                    left: scrollAmount(),
                    behavior: 'smooth'
                }));
            });
        </script>
    </section>

    <section id="galeri" class="sec-bg py-20">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-14">
            <h2 class="text-3xl font-extrabold t sm:text-[32px]">Galeri</h2>
            <div class="mt-12 grid grid-cols-2 gap-4 md:grid-cols-4">
                @forelse($fotos as $index => $foto)
                    @php
                        $src = $foto->path
                            ? (Str::startsWith($foto->path, 'http')
                                ? $foto->path
                                : asset('storage/' . $foto->path))
                            : null;
                        $isVideo = $foto->type === 'video';

                        $span = in_array($index % 6, [0, 5]) ? 'md:col-span-2' : 'md:col-span-1';
                    @endphp
                    <div class="galeri-item {{ $span }} relative h-[160px] cursor-pointer rounded-lg p-2 sm:h-[180px] sm:p-3 md:h-[210px] group"
                        style="background:var(--bg-section);border:1px solid var(--border);"
                        onclick="openLightbox('{{ $src }}', '{{ $foto->keterangan ?? 'Galeri' }}', {{ $isVideo ? 'true' : 'false' }})">
                        @if ($src && $isVideo)
                            <video class="h-full w-full rounded-md object-cover" muted preload="metadata">
                                <source src="{{ $src }}" type="video/mp4">
                            </video>
                            <div
                                class="absolute inset-3 flex items-center justify-center rounded-md bg-black/20 group-hover:bg-black/40 transition-all">
                                <svg class="w-12 h-12 text-white/80" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        @elseif ($src)
                            <img class="h-full w-full rounded-md object-cover" src="{{ $src }}"
                                alt="{{ $foto->keterangan ?? 'Galeri' }}" loading="lazy">
                            <div class="absolute inset-3 rounded-md bg-black/0 group-hover:bg-black/25 transition-all">
                            </div>
                        @else
                            <div class="flex h-full w-full items-center justify-center rounded-md"
                                style="background:var(--bg-section);color:#9ca3af;">
                                <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM8.5 11.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="tm col-span-full py-8">Tidak ada foto galeri yang tersedia saat ini.</p>
                @endforelse
            </div>
            <a href="{{ route('photos') }}" class="btn btn-gold mt-12">Lihat Semua Foto</a>
        </div>
    </section>
@endsection
