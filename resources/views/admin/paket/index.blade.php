@extends('components.layout.admin')

@section('title', 'Kelola Paket Tour')
@section('header', 'Kelola Paket Tour')

@section('content')
    <style>
        *,
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* ── CSS Variables ── */
        :root {
            --gold: #D4A017;
            --gold-dark: #b8860b;
            --gold-light: #f0c94d;
            --orange: #FF9357;
        }

        [data-theme="light"] {
            --bg: #F2F3F7;
            --bg-card: #FFFFFF;
            --text: #1a1a1a;
            --text-muted: #6b7280;
            --border: #E5E7EB;
            --table-head: #F9FAFB;
            --table-border: #F3F4F6;
            --shadow-card: 0 2px 8px rgba(0, 0, 0, .06);
            --sidebar-active-bg: #FFF4EB;
            --sidebar-active-text: #D4A017;
        }

        [data-theme="dark"] {
            --bg: #0f1117;
            --bg-card: #1e2130;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #2d3348;
            --table-head: #1a1f2e;
            --table-border: #2a3045;
            --shadow-card: 0 2px 12px rgba(0, 0, 0, .3);
            --sidebar-active-bg: rgba(212, 160, 23, .12);
            --sidebar-active-text: #f0c94d;
        }

        /* ── Card ── */
        .adm-card {
            background: var(--bg-card);
            border-radius: 14px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        /* ── Table ── */
        .adm-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .adm-tbl thead th {
            background: var(--table-head);
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 13px 18px;
            text-align: left;
            border-bottom: 1px solid var(--table-border);
        }

        .adm-tbl tbody td {
            padding: 14px 18px;
            font-size: 14px;
            color: var(--text);
            border-bottom: 1px solid var(--table-border);
        }

        .adm-tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .adm-tbl tbody tr:hover {
            background: var(--sidebar-active-bg);
        }

        /* ── Buttons ── */
        .btn-orange {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--orange);
            color: #fff;
            padding: 10px 20px;
            border-radius: 9px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: background .2s;
            text-decoration: none;
        }

        .btn-orange:hover {
            background: #e07c3d;
        }

        .btn-view {
            background: transparent;
            color: #8b5cf6;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background .15s;
        }

        .btn-view:hover {
            background: rgba(139, 92, 246, .1);
        }

        .btn-edit {
            background: transparent;
            color: var(--gold);
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background .15s;
        }

        .btn-edit:hover {
            background: rgba(212, 160, 23, .12);
        }

        .btn-danger {
            background: transparent;
            color: #ef4444;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background .15s;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, .1);
        }

        /* ── Badge durasi ── */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-day {
            background: #FFF4EB;
            color: var(--orange);
        }

        .badge-inap {
            background: #EFF6FF;
            color: #2563eb;
        }

        [data-theme="dark"] .badge-day {
            background: rgba(255, 147, 87, .15);
            color: #ff9357;
        }

        [data-theme="dark"] .badge-inap {
            background: rgba(37, 99, 235, .15);
            color: #60a5fa;
        }

        /* ── Thumbnail destinasi ── */
        .dest-thumb {
            width: 44px;
            height: 34px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e5e7eb;
            overflow: hidden;
            flex-shrink: 0;
        }

        .dest-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── Komponen badge ── */
        .komp-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        /* ── Pagination ── */
        .pg-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pg-info {
            font-size: 13px;
            color: var(--text-muted);
        }
    </style>
    {{-- Heading & Tombol Tambah --}}
    <div class="mb-[22px] flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 style="font-size:24px;font-weight:700;color:var(--text);margin:0;">Kelola Paket Tour</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:4px 0 0;">Kelola semua paket tour yang tersedia</p>
        </div>
        <a href="{{ route('admin.paket.create') }}" class="btn-orange min-h-11 w-full justify-center sm:w-auto">
            <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Paket
        </a>
    </div>

    <div class="adm-card">
        <div class="overflow-x-auto">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Paket</th>
                        <th>Durasi</th>
                        <th>Harga / Pax</th>
                        <th>Komponen</th>
                        <th>Rundown</th>
                        <th style="width:120px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $index => $paket)
                        <tr>
                            <td style="color:var(--text-muted);font-size:13px;">
                                {{ $pakets->firstItem() + $index }}
                            </td>

                            {{-- Nama Paket + Note --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    {{--
                                        Thumbnail: ambil dari cover image Paket (jika ada).
                                    --}}
                                    @if ($paket->image)
                                        <div class="dest-thumb">
                                            <img src="{{ asset('storage/' . $paket->image) }}"
                                                alt="{{ $paket->nama_paket }}" />
                                        </div>
                                    @else
                                        <div class="dest-thumb" style="background:linear-gradient(135deg,#FFF4EB,#fde68a);">
                                            <svg style="width:18px;height:18px;color:var(--orange);" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div>
                                        <p style="font-weight:600;font-size:14px;color:var(--text);margin:0;">
                                            {{ $paket->nama_paket }}
                                        </p>
                                        <p
                                            style="font-size:12px;color:var(--text-muted);margin:2px 0 0;
                                            max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ Str::limit($paket->note, 40) }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Badge Durasi --}}
                            <td>
                                @php
                                    $isInap = str_contains(strtolower($paket->durasi ?? ''), 'malam');
                                @endphp
                                <span class="badge {{ $isInap ? 'badge-inap' : 'badge-day' }}">
                                    {{ $paket->durasi ?? '-' }}
                                </span>
                            </td>

                            {{-- Harga --}}
                            <td style="font-weight:600;color:var(--orange);">
                                Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                            </td>

                            {{--
                                Komponen: semua berasal dari tabel fasilitas (kolom tipe_fasilitas).
                                Tidak ada tabel konsumsi/akomodasi/transportasi terpisah.
                                Group fasilitas berdasarkan tipe_fasilitas.
                            --}}
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    @php
                                        $fasilitasGroup = $paket->fasilitas->groupBy('tipe_fasilitas');
                                        $tipeStyle = [
                                            'tempat' => ['bg' => '#EFF6FF', 'color' => '#2563eb'],
                                            'konsumsi' => ['bg' => '#F0FDF4', 'color' => '#16a34a'],
                                            'akomodasi' => ['bg' => '#FAF5FF', 'color' => '#7c3aed'],
                                            'transportasi' => ['bg' => '#FFF4EB', 'color' => 'var(--orange)'],
                                        ];
                                    @endphp

                                    {{-- Badge tempat dari relasi destinasis --}}
                                    @if ($paket->destinasis->count() > 0)
                                        <span class="komp-badge" style="background:#EFF6FF;color:#2563eb;">
                                            {{ $paket->destinasis->count() }} Destinasi
                                        </span>
                                    @endif

                                    {{-- Badge per tipe_fasilitas --}}
                                    @forelse ($fasilitasGroup as $tipe => $items)
                                        @php
                                            $style = $tipeStyle[strtolower($tipe)] ?? [
                                                'bg' => '#F3F4F6',
                                                'color' => '#6b7280',
                                            ];
                                        @endphp
                                        <span class="komp-badge"
                                            style="background:{{ $style['bg'] }};color:{{ $style['color'] }};">
                                            {{ $items->count() }} {{ ucfirst($tipe) }}
                                        </span>
                                    @empty
                                    @endforelse

                                    @if ($paket->destinasis->count() === 0 && $paket->fasilitas->count() === 0)
                                        <span style="font-size:12px;color:var(--text-muted);">—</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Rundown --}}
                            <td>
                                @if ($paket->rundowns->count() > 0)
                                    <p style="font-size:12px;color:var(--text-muted);max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $paket->rundowns->pluck('acara')->join(', ') }}">
                                        {{ $paket->rundowns->count() }} Rundown
                                    </p>
                                @else
                                    <span style="font-size:12px;color:var(--text-muted);">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td style="text-align:center;">
                                <div style="display:inline-flex;align-items:center;gap:2px;">
                                    <a href="{{ route('admin.paket.show', $paket->id) }}" class="btn-view"
                                        title="Lihat Detail">
                                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.paket.edit', $paket->id) }}" class="btn-edit" title="Edit">
                                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST"
                                        class="inline" data-confirm="delete" data-confirm-title="Apakah anda yakin menghapus paket?"
                                        data-confirm-message="Data akan hilang dan tidak bisa dikembalikan">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger" title="Hapus">
                                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:60px 20px;text-align:center;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                                    <div
                                        style="width:60px;height:60px;border-radius:50%;background:var(--table-head);
                                        display:flex;align-items:center;justify-content:center;">
                                        <svg style="width:28px;height:28px;color:var(--text-muted);" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p style="font-weight:600;color:var(--text);margin:0;">Belum ada paket tour</p>
                                    <p style="font-size:13px;color:var(--text-muted);margin:0;">Tambahkan paket tour pertama
                                        Anda</p>
                                    <a href="{{ route('admin.paket.create') }}" class="btn-orange" style="margin-top:4px;">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pakets->hasPages())
            <div class="pg-wrap" style="border-top:1px solid var(--border);">
                <p class="pg-info">
                    Menampilkan {{ $pakets->firstItem() }}–{{ $pakets->lastItem() }}
                    dari {{ $pakets->total() }} paket
                </p>
                <div>{{ $pakets->links() }}</div>
            </div>
        @else
            <div class="pg-wrap" style="border-top:1px solid var(--border);">
                <p class="pg-info">Total {{ $pakets->total() }} paket</p>
            </div>
        @endif
    </div>
@endsection
