@extends('components.layout.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <style>
        *,
        body {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --gold: #D4A017;
            --gold-dark: #b8860b;
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
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-card);
            padding: 22px 26px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: background .3s, border-color .3s;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0 0 4px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
            margin: 0;
        }

        .adm-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

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

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-pending {
            background: #FFF4EB;
            color: var(--orange);
        }

        .badge-selesai {
            background: #ECFDF5;
            color: #10b981;
        }

        .badge-batal {
            background: #FEF2F2;
            color: #ef4444;
        }

        .badge-proses {
            background: #EFF6FF;
            color: #2563eb;
        }

        [data-theme="dark"] .badge-pending {
            background: rgba(255, 147, 87, .15);
            color: #ff9357;
        }

        [data-theme="dark"] .badge-selesai {
            background: rgba(16, 185, 129, .15);
            color: #34d399;
        }

        [data-theme="dark"] .badge-batal {
            background: rgba(239, 68, 68, .15);
            color: #f87171;
        }

        [data-theme="dark"] .badge-proses {
            background: rgba(37, 99, 235, .15);
            color: #60a5fa;
        }

        .btn-view {
            background: transparent;
            color: #8b5cf6;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 6px;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-view:hover {
            background: rgba(139, 92, 246, .1);
        }

        .empty-state {
            text-align: center;
            padding: 48px 0;
            color: var(--text-muted);
            font-size: 14px;
        }
    </style>

    <h1 class="mb-6 text-2xl font-bold text-[var(--admin-text)] sm:text-[26px]">Dashboard</h1>

    {{-- ── Stat Cards ── --}}
    <div class="mb-8 grid grid-cols-1 gap-[18px] md:grid-cols-2 xl:grid-cols-3">

        {{-- Total Paket --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFF4EB;">
                <svg style="width:24px;height:24px;color:var(--orange);" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Paket</p>
                <p class="stat-value">{{ $totalPaket }}</p>
            </div>
        </div>

        {{-- Total Pesanan --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5;">
                <svg style="width:24px;height:24px;color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Pesanan</p>
                <p class="stat-value">{{ $orders->count() }}</p>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB;">
                <svg style="width:24px;height:24px;color:var(--gold);" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="stat-label">Revenue (Selesai)</p>
                <p class="stat-value" style="font-size:20px;margin-top:4px;">
                    Rp {{ number_format($revenue, 0, ',', '.') }}
                </p>
            </div>
        </div>

    </div>

    {{-- ── Tabel Pesanan Terbaru ── --}}
    <div class="adm-card">
        <div class="flex flex-col gap-3 border-b border-[var(--border)] px-5 py-[18px] sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-base font-bold text-[var(--admin-text)]">Pesanan Terbaru</h2>
            <a href="{{ route('admin.pesanan.index') }}"
                class="inline-flex min-h-11 items-center text-sm font-semibold text-[var(--gold)]">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="adm-tbl">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Pemesan</th>
                        <th>No. HP</th>
                        <th>Paket</th>
                        <th>Jumlah Orang</th>
                        <th>Tanggal Tour</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th style="width:80px;text-align:center;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $i => $p)
                        <tr>
                            <td style="color:var(--text-muted);font-size:13px;">{{ $i + 1 }}</td>
                            <td style="font-weight:500;">{{ $p->nama_pemesan }}</td>
                            <td style="color:var(--text-muted);">{{ $p->no_hp }}</td>
                            <td>{{ $p->is_custom ? 'Custom' : ($p->paket->nama_paket ?? '-') }}</td>
                            <td>{{ $p->jumlah_orang }} Orang</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_acara)->format('d M Y') }}</td>
                            {{-- <td>
                                <div style="font-weight:600; color:var(--text);">
                                    Rp
                                    {{ number_format(($p->paket->harga_paket ?? 0) * ($p->jumlah_orang ?? 0), 0, ',', '.') }}
                                </div>
                                @if ($p->diskon > 0)
                                    <div style="font-size:12px;color:#16a34a;margin-top:2px;font-weight:500;">
                                        Total: Rp {{ number_format($p->total_harga, 0, ',', '.') }} (Disc
                                        {{ $p->diskon }}%)
                                    </div>
                                @endif
                            </td> --}}
                            <td class="px-4 py-3 text-sm">
                                <div class="font-semibold text-[var(--text)]">
                                    Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                </div>
                                @if ($p->diskon > 0)
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium mt-0.5">
                                        Disc {{ $p->diskon }}%
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match ($p->status) {
                                        'selesai' => 'badge-selesai',
                                        'batal' => 'badge-batal',
                                        'proses' => 'badge-proses',
                                        default => 'badge-pending',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.pesanan.show', $p->id) }}" class="btn-view" title="Lihat Detail">
                                    <svg style="width:17px;height:17px;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-state">Belum ada pesanan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Grafik Pendapatan ── --}}
    <div class="mt-8">
        <h2 class="mb-[18px] text-xl font-bold text-[var(--admin-text)]">
            Grafik Pendapatan {{ $tahun }}
        </h2>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">

            {{-- Chart 1: Tren Pendapatan Bulanan --}}
            <div class="adm-card p-5 sm:p-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-[15px] font-semibold text-[var(--admin-text)]">
                        Tren Pendapatan Bulanan
                    </h3>
                    <span
                        style="display:inline-flex;align-items:center;gap:5px;font-size:11px;
                        color:#ea580c;background:#fff7ed;padding:3px 10px;border-radius:999px;">
                        <span
                            style="width:7px;height:7px;background:#f59e0b;border-radius:50%;display:inline-block;"></span>
                        Hanya Selesai
                    </span>
                </div>
                @if (array_sum($chartRevenu) === 0)
                    <div
                        style="height:300px;display:flex;flex-direction:column;align-items:center;
                        justify-content:center;color:var(--text-muted);">
                        <svg style="width:40px;height:40px;margin-bottom:10px;opacity:.35;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0
                                                                                   0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0
                                                                                   0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p style="font-size:13px;margin:0;">Belum ada pendapatan di tahun {{ $tahun }}</p>
                    </div>
                @else
                    <div id="chartPendapatan"></div>
                @endif
            </div>

            {{-- Chart 2: Pendapatan per Paket --}}
            <div class="adm-card p-5 sm:p-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-[15px] font-semibold text-[var(--admin-text)]">
                        Pendapatan per Paket
                    </h3>
                    @if (count($chartPaketLabel) > 0)
                        <span style="font-size:11px;color:var(--text-muted);">
                            Top {{ count($chartPaketLabel) }} paket
                        </span>
                    @endif
                </div>
                @if (count($chartPaketLabel) === 0)
                    <div
                        style="height:300px;display:flex;flex-direction:column;align-items:center;
                        justify-content:center;color:var(--text-muted);">
                        <svg style="width:40px;height:40px;margin-bottom:10px;opacity:.35;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p style="font-size:13px;margin:0;">Belum ada pesanan selesai</p>
                    </div>
                @else
                    <div id="chartPaket"></div>
                @endif
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/admin-dashboard.js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const bulanLabels = @json($chartBulan);
            const revenuData = @json($chartRevenu);
            const paketLabels = @json($chartPaketLabel);
            const paketData = @json($chartPaketData);

            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const textColor = isDark ? '#94a3b8' : '#6b7280';
            const gridColor = isDark ? '#2a3045' : '#f3f4f6';

            // Chart 1: Area — Tren Pendapatan Bulanan
            @if (array_sum($chartRevenu) > 0)
                new ApexCharts(document.querySelector("#chartPendapatan"), {
                    series: [{
                        name: 'Pendapatan',
                        data: revenuData
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        background: 'transparent',
                        fontFamily: 'Poppins, sans-serif',
                    },
                    colors: ['#f59e0b'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.04,
                            stops: [0, 100]
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2.5
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: bulanLabels,
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px'
                            },
                            formatter: val => 'Rp ' + (val >= 1000000 ?
                                (val / 1000000).toFixed(1) + 'jt' :
                                val.toLocaleString('id-ID'))
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                        }
                    }
                }).render();
            @endif

            // Chart 2: Bar — Pendapatan per Paket
            @if (count($chartPaketLabel) > 0)
                new ApexCharts(document.querySelector("#chartPaket"), {
                    series: [{
                        name: 'Total Pendapatan',
                        data: paketData
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        },
                        background: 'transparent',
                        fontFamily: 'Poppins, sans-serif',
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '50%',
                            distributed: true
                        }
                    },
                    colors: ['#f59e0b', '#fb923c', '#f97316', '#ea580c', '#fbbf24', '#fcd34d', '#fde68a',
                        '#fed7aa'
                    ],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    xaxis: {
                        categories: paketLabels,
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '10px'
                            },
                            trim: true,
                            maxHeight: 60
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px'
                            },
                            formatter: val => 'Rp ' + (val >= 1000000 ?
                                (val / 1000000).toFixed(1) + 'jt' :
                                val.toLocaleString('id-ID'))
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 4
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                        }
                    }
                }).render();
            @endif

            // Reload saat dark mode toggle supaya warna axis ikut berubah
            const themeToggle = document.getElementById('adminThemeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('change', () => {
                    setTimeout(() => location.reload(), 150);
                });
            }
        });
    </script>
@endpush
