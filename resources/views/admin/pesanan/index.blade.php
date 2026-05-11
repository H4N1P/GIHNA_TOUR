@extends('components.layout.admin')
@section('title', 'Daftar Pesanan')
@section('header', 'Daftar Pesanan')

@section('content')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold">Pesanan</h1>
        
        <div class="flex flex-wrap items-center gap-3">
            <form id="filterForm" action="{{ route('admin.pesanan.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Search bar with icon inside --}}
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Cari pesanan..." value="{{ request('search') }}"
                        class="pl-9 pr-3 py-2 text-sm rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 outline-none w-48">
                </div>
                
                {{-- Status dropdown (auto-submit) --}}
                <select name="status" onchange="document.getElementById('filterForm').submit()"
                    class="px-3 py-2 text-sm rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>

                {{-- Date picker (auto-submit) --}}
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="document.getElementById('filterForm').submit()"
                    class="px-3 py-2 text-sm rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 outline-none">
                
                @if(request()->anyFilled(['search', 'status', 'tanggal']))
                    <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-red-500 hover:underline font-medium">Reset</a>
                @endif
            </form>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.pesanan.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pesanan
                </a>
                <a href="{{ route('admin.pesanan.create-custom') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Pesanan Custom
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-neutral-50 dark:bg-neutral-800">
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Invoice</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Pemesan</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Paket</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Tanggal Acara</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Jumlah Pax</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Total</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Status</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-neutral-500 uppercase tracking-wider border-b border-neutral-200 dark:border-neutral-700">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $p)
                        <tr
                            class="border-b border-neutral-100 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                            <td class="px-4 py-3 text-sm font-mono text-purple-600">{{ $p->invoice }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-sm">{{ $p->nama_pemesan }}</div>
                                <div class="text-xs text-neutral-400">{{ $p->no_hp }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($p->is_custom)
                                    <span class="text-amber-600 font-medium">Custom Order</span>
                                    <div class="text-xs text-neutral-400 mt-1">
                                        {{ count($p->custom_places ?? []) }} tempat
                                    </div>
                                @else
                                    {{ $p->paket->nama_paket ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($p->tanggal_acara)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $p->jumlah_orang ?? '-' }} pax</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-semibold text-neutral-800 dark:text-neutral-200">
                                    Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                </div>
                                @if ($p->diskon > 0)
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium mt-0.5">
                                        Disc {{ $p->diskon }}%
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $p->status === 'selesai'
                                        ? 'bg-green-100 text-green-700'
                                        : ($p->status === 'batal'
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($p->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.pesanan.show', $p->id) }}"
                                        class="p-1.5 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.pesanan.edit', $p->id) }}"
                                        class="p-1.5 text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.pesanan.destroy', $p->id) }}" method="POST"
                                        data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus pesanan?"
                                        data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-neutral-400">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pesanans->hasPages())
            <div class="px-4 py-4 border-t border-neutral-200 dark:border-neutral-700">
                {{ $pesanans->links() }}
            </div>
        @endif
    </div>
@endsection
