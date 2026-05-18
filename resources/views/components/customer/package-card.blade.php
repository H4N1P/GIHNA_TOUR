@php
    $coverSrc = $paket->image 
        ? (Str::startsWith($paket->image, 'http') ? $paket->image : asset('storage/' . $paket->image))
        : null;
@endphp

<a href="{{ route('package.detail', $paket->id) }}" class="package-card" aria-label="Lihat {{ $paket->nama_paket }}">
    <div class="package-card__media">
        @if ($coverSrc)
            <img src="{{ $coverSrc }}" alt="{{ $paket->nama_paket }}" loading="lazy">
        @else
            <div class="package-card__placeholder">
                <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path
                        d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM8.5 11.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5Z" />
                </svg>
            </div>
        @endif
    </div>
    <div class="package-card__body">
        <h3 class="package-card__title">{{ $paket->nama_paket }}</h3>
        <div class="package-card__meta">
            <span class="package-card__duration">{{ $paket->durasi ?? '1 Hari' }}</span>
        </div>
        <p class="package-card__price">Rp. {{ number_format($paket->harga_paket, 0, ',', '.') }}<span>/Pax</span></p>
    </div>
</a>
