<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $standardBus = [
            ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata'],
            ['tipe' => 'transportasi', 'nama' => 'Air Conditioner, Audio'],
            ['tipe' => 'transportasi', 'nama' => 'Reclining Seat'],
        ];

        $standardAkomodasi = [
            ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
            ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Obyek Wisata'],
            ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
            ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
        ];

        $standardKonsumsi = [
            ['tipe' => 'konsumsi', 'nama' => 'Makan sesuai Program'],
            ['tipe' => 'konsumsi', 'nama' => 'Snack'],
            ['tipe' => 'konsumsi', 'nama' => 'Air mineral'],
        ];

        $oneDayRundown = [
            ['waktu' => '06.00', 'acara' => 'Berangkat dari titik kumpul', 'deskripsi' => 'Peserta berkumpul dan memulai perjalanan menuju destinasi wisata.'],
            ['waktu' => '10.00', 'acara' => 'Kunjungan destinasi wisata', 'deskripsi' => 'Menikmati destinasi utama sesuai paket yang dipilih.'],
            ['waktu' => '12.00', 'acara' => 'Makan siang', 'deskripsi' => 'Istirahat dan makan siang bersama rombongan.'],
            ['waktu' => '15.00', 'acara' => 'Wisata lanjutan / acara bebas', 'deskripsi' => 'Melanjutkan kunjungan atau waktu bebas di area wisata.'],
            ['waktu' => '18.00', 'acara' => 'Perjalanan pulang', 'deskripsi' => 'Rombongan kembali menuju titik kumpul awal.'],
        ];

        $pakets = [
            [
                'nama_paket' => 'Jogjakarta One Day - Pandansari',
                'harga_paket' => 350000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Pantai Pandansari',
                    'Gumuk Pasir Parangkusumo',
                    'Pinus Pengger',
                    'Malioboro',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'konsumsi', 'nama' => 'Makan 2x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral 330 ml'],
                ]),
            ],
            [
                'nama_paket' => 'Jogja Inap',
                'harga_paket' => 750000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga untuk SEAT 50 PAX. Termasuk kaos per peserta dan doorprice. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Outbound di Pantai',
                    'Jeep Merapi',
                    'Gua Pindul',
                    'Hotel',
                    'Malioboro',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'konsumsi', 'nama' => 'Makan sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral'],
                    ['tipe' => 'konsumsi', 'nama' => 'Kaos per peserta'],
                    ['tipe' => 'konsumsi', 'nama' => 'Doorprice'],
                ]),
                'rundowns' => [
                    ['waktu' => 'Hari 1 - 06.00', 'acara' => 'Berangkat menuju Yogyakarta', 'deskripsi' => 'Peserta berkumpul dan memulai perjalanan menuju area wisata Yogyakarta.'],
                    ['waktu' => 'Hari 1 - 11.00', 'acara' => 'Kunjungan wisata dan makan siang', 'deskripsi' => 'Mengunjungi destinasi pilihan sesuai program dan istirahat makan siang.'],
                    ['waktu' => 'Hari 1 - 15.00', 'acara' => 'Outbound / aktivitas wisata', 'deskripsi' => 'Kegiatan outbound atau aktivitas wisata sesuai paket.'],
                    ['waktu' => 'Hari 1 - 19.00', 'acara' => 'Check-in dan acara bebas', 'deskripsi' => 'Check-in penginapan dan waktu bebas untuk peserta.'],
                    ['waktu' => 'Hari 2 - 08.00', 'acara' => 'Wisata lanjutan', 'deskripsi' => 'Melanjutkan perjalanan wisata ke destinasi berikutnya.'],
                    ['waktu' => 'Hari 2 - 15.00', 'acara' => 'Perjalanan pulang', 'deskripsi' => 'Rombongan kembali menuju titik kumpul awal.'],
                ],
            ],
            [
                'nama_paket' => 'Dewata Bali',
                'harga_paket' => 1900000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Bali',
                    'Tour Dewata Bali',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel 2 malam'],
                ], $standardKonsumsi),
                'rundowns' => [
                    ['waktu' => 'Hari 1 - 06.00', 'acara' => 'Berangkat menuju Bali', 'deskripsi' => 'Peserta berkumpul dan memulai perjalanan menuju Bali.'],
                    ['waktu' => 'Hari 1 - 20.00', 'acara' => 'Check-in / persiapan tour', 'deskripsi' => 'Tiba di area tujuan, check-in, dan persiapan kegiatan berikutnya.'],
                    ['waktu' => 'Hari 2 - 08.00', 'acara' => 'Tour utama Bali', 'deskripsi' => 'Mengikuti rangkaian kunjungan wisata utama sesuai program.'],
                    ['waktu' => 'Hari 3 - 08.00', 'acara' => 'Acara bebas dan oleh-oleh', 'deskripsi' => 'Waktu bebas, belanja oleh-oleh, dan persiapan pulang.'],
                    ['waktu' => 'Hari 3 - 13.00', 'acara' => 'Perjalanan pulang', 'deskripsi' => 'Rombongan kembali menuju titik kumpul awal.'],
                ],
            ],
            [
                'nama_paket' => 'Batu Malang Inap',
                'harga_paket' => 1500000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Jatim Park 1',
                    'Wonderland',
                    'Museum Angkut',
                    'De Laponte',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel 1 malam'],
                ], [
                    ['tipe' => 'konsumsi', 'nama' => 'Makan sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral 330 ml'],
                ]),
            ],
            [
                'nama_paket' => 'Bandung One Day',
                'harga_paket' => 600000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Farm House',
                    'Floating Market',
                    'The Great Asia Afrika',
                    'Pasar Baru',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, $standardKonsumsi),
            ],
            [
                'nama_paket' => 'Bandung Jakarta Inap 1 Malam',
                'harga_paket' => 1400000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga untuk 46 pax. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Jakarta',
                    'Bandung',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'akomodasi', 'nama' => 'Kaos'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel'],
                ], $standardKonsumsi),
            ],
            [
                'nama_paket' => 'Jogjakarta One Day',
                'harga_paket' => 350000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Keraton',
                    'Taman Sari',
                    'Parangtritis',
                    'Malioboro',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, $standardKonsumsi),
                'rundowns' => $oneDayRundown,
            ],
            [
                'nama_paket' => 'Paket Wisata Semarang 1',
                'harga_paket' => 500000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Lawang Sewu',
                    'Kota Lama Semarang',
                    'Sam Poo Kong',
                    'Masjid Agung Semarang',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'konsumsi', 'nama' => 'Makan sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral 600 ml'],
                ]),
            ],
            [
                'nama_paket' => 'Karimunjawa 3D2N Jepara - Homestay Kipas',
                'harga_paket' => 1850000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga untuk 30 pax. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Tour Laut Karimunjawa',
                    'Tour Darat Karimunjawa',
                    'Jepara',
                ],
                'fasilitas' => [
                    ['tipe' => 'akomodasi', 'nama' => 'Homestay kipas'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan selama tour'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour laut dan darat'],
                    ['tipe' => 'akomodasi', 'nama' => 'Guide dan dokumentasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Tiket kapal express PP'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket destinasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Transportasi selama di lokasi'],
                ],
            ],
            [
                'nama_paket' => 'Karimunjawa 3D2N Jepara - Homestay AC',
                'harga_paket' => 2100000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga untuk 30 pax. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Tour Laut Karimunjawa',
                    'Tour Darat Karimunjawa',
                    'Jepara',
                ],
                'fasilitas' => [
                    ['tipe' => 'akomodasi', 'nama' => 'Homestay AC'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan selama tour'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour laut dan darat'],
                    ['tipe' => 'akomodasi', 'nama' => 'Guide dan dokumentasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Tiket kapal express PP'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket destinasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Transportasi selama di lokasi'],
                ],
            ],
            [
                'nama_paket' => 'Karimunjawa 3D2N Jepara - Hotel/Resort',
                'harga_paket' => 2350000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga untuk 30 pax. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Tour Laut Karimunjawa',
                    'Tour Darat Karimunjawa',
                    'Jepara',
                ],
                'fasilitas' => [
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel / Resort'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan selama tour'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour laut dan darat'],
                    ['tipe' => 'akomodasi', 'nama' => 'Guide dan dokumentasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Tiket kapal express PP'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket destinasi'],
                    ['tipe' => 'transportasi', 'nama' => 'Transportasi selama di lokasi'],
                ],
            ],
            [
                'nama_paket' => 'Outbound Baturaden',
                'harga_paket' => 100000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 100 siswa. Bentuk kegiatan outbound fun game dan game challenge. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Baturaden',
                    'Curug Bayan',
                    'Ketenger',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Mobil Dalmas'],
                    ['tipe' => 'akomodasi', 'nama' => 'Trainer atau Fasilitator'],
                    ['tipe' => 'akomodasi', 'nama' => 'HTM'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi kegiatan'],
                    ['tipe' => 'akomodasi', 'nama' => 'Parkir dll'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan 1x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack 1x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral 600 ml 1x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral selama kegiatan'],
                ],
                'rundowns' => [
                    ['waktu' => '07.00', 'acara' => 'Berangkat menuju lokasi', 'deskripsi' => 'Peserta berkumpul dan berangkat menuju area outbound.'],
                    ['waktu' => '08.30', 'acara' => 'Pembukaan dan briefing', 'deskripsi' => 'Trainer memberikan arahan kegiatan dan pembagian kelompok.'],
                    ['waktu' => '09.00', 'acara' => 'Fun game dan team building', 'deskripsi' => 'Kegiatan permainan untuk membangun komunikasi dan kerja sama.'],
                    ['waktu' => '12.00', 'acara' => 'Makan siang', 'deskripsi' => 'Istirahat dan makan siang bersama peserta.'],
                    ['waktu' => '13.00', 'acara' => 'Game challenge', 'deskripsi' => 'Tantangan kelompok untuk melatih leadership dan kekompakan.'],
                    ['waktu' => '15.00', 'acara' => 'Penutupan dan perjalanan pulang', 'deskripsi' => 'Evaluasi singkat, penutupan, dan kembali ke titik kumpul.'],
                ],
            ],
            [
                'nama_paket' => 'Jakarta Bandung Inap 2 Malam',
                'harga_paket' => 1470000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Jakarta',
                    'Bandung',
                ],
                'fasilitas' => array_merge($standardBus, $standardAkomodasi, [
                    ['tipe' => 'akomodasi', 'nama' => 'Kaos'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel'],
                ], $standardKonsumsi),
            ],
            [
                'nama_paket' => 'Trip Dieng One Day',
                'harga_paket' => 425000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 20 PAX. Transportasi menggunakan ELF. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Telaga Menjer',
                    'Dieng Plateau',
                    'Candi Arjuna',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'ELF'],
                    ['tipe' => 'transportasi', 'nama' => 'Air Conditioner, Audio'],
                    ['tipe' => 'transportasi', 'nama' => 'Reclining Seat'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Obyek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan sesuai program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air mineral 330 ml selama perjalanan'],
                ],
                'rundowns' => [
                    ['waktu' => '04.00', 'acara' => 'Berangkat menuju Dieng', 'deskripsi' => 'Peserta berkumpul lebih awal dan memulai perjalanan menuju kawasan Dieng.'],
                    ['waktu' => '08.00', 'acara' => 'Telaga Menjer', 'deskripsi' => 'Kunjungan wisata ke Telaga Menjer.'],
                    ['waktu' => '10.30', 'acara' => 'Dieng Plateau dan Candi Arjuna', 'deskripsi' => 'Menikmati kawasan Dieng dan mengunjungi kompleks Candi Arjuna.'],
                    ['waktu' => '12.30', 'acara' => 'Makan siang', 'deskripsi' => 'Istirahat dan makan siang bersama rombongan.'],
                    ['waktu' => '15.00', 'acara' => 'Perjalanan pulang', 'deskripsi' => 'Rombongan kembali menuju titik kumpul awal.'],
                ],
            ],
        ];

        foreach ($pakets as $paketData) {
            $paketId = DB::table('pakets')->insertGetId([
                'nama_paket' => $paketData['nama_paket'],
                'harga_paket' => $paketData['harga_paket'],
                'durasi' => $paketData['durasi'],
                'note' => $paketData['note'],
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($paketData['destinasis'] as $namaDestinasi) {
                DB::table('destinasis')->insert([
                    'nama_destinasi' => $namaDestinasi,
                    'id_paket' => $paketId,
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($paketData['fasilitas'] as $fasilitas) {
                DB::table('fasilitas')->insert([
                    'tipe_fasilitas' => $fasilitas['tipe'],
                    'nama_fasilitas' => $fasilitas['nama'],
                    'id_paket' => $paketId,
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($paketData['rundowns'] ?? [] as $rundown) {
                DB::table('rundowns')->insert([
                    'id_paket' => $paketId,
                    'waktu' => $rundown['waktu'],
                    'acara' => $rundown['acara'],
                    'deskripsi' => $rundown['deskripsi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
