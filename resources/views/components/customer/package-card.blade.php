@php
    $cover = null;
    if ($paket->relationLoaded('fotos') && $paket->fotos->isNotEmpty()) {
        $cover = $paket->fotos->first();
    } elseif ($paket->relationLoaded('tempats')) {
        $cover = $paket->tempats->flatMap(fn ($tempat) => $tempat->galleries ?? collect())->first();
    }
    $coverSrc = $cover?->path
        ? (Str::startsWith($cover->path, 'http') ? $cover->path : asset('storage/' . $cover->path))
        : null;
@endphp

<a href="{{ route('package.detail', $paket->id) }}" class="package-card" aria-label="Lihat {{ $paket->nama_paket }}">
    <div class="package-card__media">
        @if ($coverSrc)
            <img src="{{ $coverSrc }}" alt="{{ $paket->nama_paket }}" loading="lazy">
        @else
            <div class="package-card__placeholder"></div>
        @endif
        <div class="package-card__overlay"></div>
        <div class="package-card__content">
            <h3>{{ $paket->nama_paket }}</h3>
            <p>{{ $paket->durasi ?? '1 Hari' }}</p>
            <strong>Rp. {{ number_format($paket->harga_paket, 0, ',', '.') }}<span>/Pax</span></strong>
        </div>
    </div>
</a>
