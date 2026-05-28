@extends('components.layout.customer')

@section('title', 'Semua Paket - Ghina Tour Travel')

@section('content')
    <section class="search-hero">
        <form action="{{ route('packages') }}" method="GET" class="search-panel">
            <div class="search-panel__field">
                <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search">
                <span class="search-panel__icon" aria-hidden="true">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.2-5.2m1.7-5.3a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </span>
            </div>
            <button type="submit">Cari</button>
            @if (($query ?? '') !== '')
                <a href="{{ route('packages') }}" class="inline-flex items-center justify-center">Reset</a>
            @endif
        </form>
    </section>

    <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-14 lg:px-16">
        <h1 class="mb-8 text-3xl font-extrabold leading-tight text-[#202638] dark:text-white sm:text-[44px]">
            {{ ($query ?? '') !== '' ? 'Hasil Pencarian' : 'Semua Paket' }}
        </h1>

        @if (($query ?? '') !== '')
            <p class="tm -mt-5 mb-8">Menampilkan paket untuk "{{ $query }}".</p>
        @endif

        @if ($pakets->count() > 0)
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($pakets as $paket)
                    @include('components.customer.package-card', ['paket' => $paket])
                @endforeach
            </div>

            @include('components.ui.pagination', ['paginator' => $pakets])
        @else
            <div class="rounded-3xl border border-[var(--border)] bg-[var(--bg-card)] px-6 py-16 text-center">
                <h2 class="text-2xl font-extrabold t">Tidak Ada Paket Ditemukan</h2>
                <p class="tm mt-2">Coba gunakan kata kunci lain atau lihat semua paket yang tersedia.</p>
                <a href="{{ route('packages') }}" class="btn btn-gold mt-6 w-full sm:w-auto">Lihat Semua Paket</a>
            </div>
        @endif
    </main>
@endsection
