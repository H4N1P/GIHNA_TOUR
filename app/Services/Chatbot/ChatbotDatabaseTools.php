<?php

namespace App\Services\Chatbot;

use App\Models\CompanyProfile;
use App\Models\Paket;
use App\Models\Pesanan;

class ChatbotDatabaseTools
{
    public function declarations(): array
    {
        return [
            [
                'name' => 'get_company_profile',
                'description' => 'Get Ghina Tour Travel company profile, WhatsApp, email, address, Instagram, about, and vision mission. Use for contact, office, company, or admin questions.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => (object) [],
                ],
            ],
            [
                'name' => 'search_tour_packages',
                'description' => 'Search available tour packages by destination, package name, facility, note, or maximum price. Use for package recommendations, prices, destination availability, cheapest package, and facilities overview.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'query' => [
                            'type' => 'string',
                            'description' => 'Destination, package name, facility, or keyword from the customer question. Leave empty to list packages.',
                        ],
                        'max_price' => [
                            'type' => 'number',
                            'description' => 'Maximum package price in Indonesian Rupiah if the customer asks for a budget or cheapest options.',
                        ],
                        'sort_by' => [
                            'type' => 'string',
                            'description' => 'How to sort packages. Use "cheapest" for cheapest, "expensive" for most expensive, and "popular" for most popular / best seller / paling laris.',
                            'enum' => ['cheapest', 'expensive', 'popular'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'get_package_detail',
                'description' => 'Get complete details for one package, including destinations, facilities, rundown, duration, price, and notes. Use after a package is identified.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'package_id' => [
                            'type' => 'number',
                            'description' => 'The package ID returned by search_tour_packages.',
                        ],
                    ],
                    'required' => ['package_id'],
                ],
            ],
            [
                'name' => 'search_orders',
                'description' => 'Search customer orders by customer phone number or invoice number. Use only when the customer asks about order status, invoice, booking, or pesanan.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'customer_phone' => [
                            'type' => 'string',
                            'description' => 'Customer phone number. Ask the customer for it if neither phone nor invoice is provided.',
                        ],
                        'invoice' => [
                            'type' => 'string',
                            'description' => 'Invoice number. Ask the customer for it if neither phone nor invoice is provided.',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function execute(string $name, array $arguments): array
    {
        $tools = [
            'get_company_profile' => fn () => $this->companyProfile(),
            'search_tour_packages' => fn () => $this->searchTourPackages($arguments),
            'get_package_detail' => fn () => $this->packageDetail((int) ($arguments['package_id'] ?? 0)),
            'search_orders' => fn () => $this->searchOrders($arguments),
        ];

        return ($tools[$name] ?? fn () => [
            'ok' => false,
            'message' => 'Tool tidak tersedia untuk chatbot customer service.',
        ])();
    }

    private function companyProfile(): array
    {
        $profile = CompanyProfile::query()->first();

        return [
            'ok' => true,
            'company' => $profile ? [
                'about' => $profile->about,
                'vision_mission' => $profile->vision_mission,
                'whatsapp' => $profile->whatsapp,
                'email' => $profile->email,
                'address' => $profile->address,
                'instagram' => $profile->instagram,
            ] : null,
        ];
    }

    private function searchTourPackages(array $arguments): array
    {
        $query = trim((string) ($arguments['query'] ?? ''));
        $maxPrice = isset($arguments['max_price']) ? (float) $arguments['max_price'] : null;
        $sortBy = trim((string) ($arguments['sort_by'] ?? 'cheapest'));

        $pakets = Paket::query()
            ->with(['destinasis', 'fasilitas'])
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($nested) use ($query) {
                    $nested
                        ->where('nama_paket', 'like', "%{$query}%")
                        ->orWhere('note', 'like', "%{$query}%")
                        ->orWhereHas('destinasis', fn ($destinasi) => $destinasi->where('nama_destinasi', 'like', "%{$query}%"))
                        ->orWhereHas('fasilitas', fn ($fasilitas) => $fasilitas->where('nama_fasilitas', 'like', "%{$query}%"));
                });
            })
            ->when($maxPrice !== null && $maxPrice > 0, fn ($builder) => $builder->where('harga_paket', '<=', $maxPrice))
            ->when($sortBy === 'expensive', fn ($builder) => $builder->orderBy('harga_paket', 'desc'))
            ->when($sortBy === 'popular', fn ($builder) => $builder->withCount('pesanans')->orderBy('pesanans_count', 'desc'))
            ->when($sortBy === 'cheapest' || !in_array($sortBy, ['expensive', 'popular']), fn ($builder) => $builder->orderBy('harga_paket', 'asc'))
            ->limit(8)
            ->get();

        return [
            'ok' => true,
            'count' => $pakets->count(),
            'packages' => $pakets->map(fn (Paket $paket) => [
                'id' => $paket->id,
                'name' => $paket->nama_paket,
                'duration' => $paket->durasi,
                'price' => (float) $paket->harga_paket,
                'destinations' => $paket->destinasis->pluck('nama_destinasi')->values(),
                'facilities' => $paket->fasilitas->map(fn ($fasilitas) => [
                    'type' => $fasilitas->tipe_fasilitas,
                    'name' => $fasilitas->nama_fasilitas,
                ])->values(),
                'note' => $paket->note,
            ])->values(),
        ];
    }

    private function packageDetail(int $packageId): array
    {
        $paket = Paket::query()
            ->with(['destinasis', 'fasilitas', 'rundowns'])
            ->find($packageId);

        return [
            'ok' => (bool) $paket,
            'package' => $paket ? [
                'id' => $paket->id,
                'name' => $paket->nama_paket,
                'duration' => $paket->durasi,
                'price' => (float) $paket->harga_paket,
                'destinations' => $paket->destinasis->pluck('nama_destinasi')->values(),
                'facilities' => $paket->fasilitas->map(fn ($fasilitas) => [
                    'type' => $fasilitas->tipe_fasilitas,
                    'name' => $fasilitas->nama_fasilitas,
                ])->values(),
                'rundown' => $paket->rundowns->map(fn ($rundown) => [
                    'time' => $rundown->waktu,
                    'activity' => $rundown->acara,
                    'description' => $rundown->deskripsi,
                ])->values(),
                'note' => $paket->note,
            ] : null,
        ];
    }

    private function searchOrders(array $arguments): array
    {
        $phone = $this->digitsOnly((string) ($arguments['customer_phone'] ?? ''));
        $invoice = trim((string) ($arguments['invoice'] ?? ''));

        $orders = Pesanan::query()
            ->with('paket')
            ->when($phone !== '', fn ($builder) => $builder->where('no_hp', 'like', "%{$phone}%"))
            ->when($invoice !== '', fn ($builder) => $builder->orWhere('invoice', $invoice))
            ->latest()
            ->limit(5)
            ->get();

        return [
            'ok' => $phone !== '' || $invoice !== '',
            'message' => $phone === '' && $invoice === ''
                ? 'Nomor HP atau invoice diperlukan untuk mengecek pesanan.'
                : null,
            'count' => $orders->count(),
            'orders' => $orders->map(fn (Pesanan $pesanan) => [
                'customer_name' => $pesanan->nama_pemesan,
                'package' => $pesanan->is_custom ? 'Paket custom' : $pesanan->paket?->nama_paket,
                'event_date' => (string) $pesanan->tanggal_acara,
                'people_count' => $pesanan->jumlah_orang,
                'total_price' => (float) $pesanan->total_harga,
                'invoice' => $pesanan->invoice,
                'status' => $pesanan->status ?: 'Menunggu Konfirmasi',
                'custom_places' => $pesanan->is_custom ? $pesanan->custom_places : null,
            ])->values(),
        ];
    }

    private function digitsOnly(string $value): string
    {
        return implode('', array_filter(str_split($value), fn (string $char) => ctype_digit($char)));
    }
}
