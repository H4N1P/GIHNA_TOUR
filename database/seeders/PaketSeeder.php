<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    private function createDummyImage($text, $folder)
    {
        $filename = uniqid() . '.jpg';
        $path = 'images/' . $folder . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $image = imagecreatetruecolor(800, 600);
        $bg = imagecolorallocate($image, rand(50, 150), rand(50, 150), rand(50, 150));
        imagefill($image, 0, 0, $bg);
        $color = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 5, 50, 280, substr($text, 0, 50), $color);
        imagestring($image, 3, 50, 310, 'Ghina Tour Travel', $color);

        imagejpeg($image, $fullPath, 80);
        imagedestroy($image);

        return $path;
    }

    public function run(): void
    {
        $pakets = [
            // ========== 1. JOGJAKARTA ONE DAY ==========
            [
                'nama_paket' => 'Jogjakarta One Day',
                'harga_paket' => 350000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Keraton Yogyakarta',
                    'Taman Sari',
                    'Pantai Parangtritis',
                    'Malioboro',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral 330ml'],
                ],
            ],

            // ========== 2. JOGJA INAP ==========
            [
                'nama_paket' => 'Jogja Inap (Outbound, Gua Pindul, Merapi)',
                'harga_paket' => 750000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga untuk SEAT 50 PAX. Termasuk kaos per peserta dan doorprice. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Outbound di Pantai',
                    'Jeep Merapi',
                    'Gua Pindul',
                    'Malioboro',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel Yogyakarta'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Kaos Per Peserta'],
                    ['tipe' => 'akomodasi', 'nama' => 'Doorprice'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral'],
                ],
            ],

            // ========== 3. DEWATA BALI ==========
            [
                'nama_paket' => 'Dewata Bali',
                'harga_paket' => 1900000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Pura Ulun Danu Beratan',
                    'Garuda Wisnu Kencana (GWK)',
                    'Tanah Lot',
                    'Pantai Kuta Bali',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel Bali (2 Malam)'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral'],
                ],
            ],

            // ========== 4. BATU MALANG INAP ==========
            [
                'nama_paket' => 'Batu Malang Inap',
                'harga_paket' => 1500000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Jatim Park 1',
                    'Wonderland Waterpark',
                    'Museum Angkut',
                    'De Laponte Dok',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel Batu (1 Malam)'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral'],
                ],
            ],

            // ========== 5. BANDUNG ONE DAY ==========
            [
                'nama_paket' => 'Bandung One Day',
                'harga_paket' => 600000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Farm House Lembang',
                    'Floating Market Lembang',
                    'The Great Asia Afrika',
                    'Pasar Baru Bandung',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral'],
                ],
            ],

            // ========== 6. BANDUNG JAKARTA INAP ==========
            [
                'nama_paket' => 'Bandung Jakarta Inap 1 Malam',
                'harga_paket' => 1400000.00,
                'durasi' => '2 Hari 1 Malam',
                'note' => 'Harga untuk 46 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Monumen Nasional (Monas)',
                    'Dunia Fantasi (Dufan)',
                    'Farm House Lembang',
                    'The Great Asia Afrika',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Hotel (1 Malam)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Kaos Per Peserta'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral'],
                ],
            ],

            // ========== 7. SEMARANG ONE DAY ==========
            [
                'nama_paket' => 'Paket Wisata Semarang',
                'harga_paket' => 500000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 50 PAX. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Lawang Sewu',
                    'Kota Lama Semarang',
                    'Sam Poo Kong',
                    'Masjid Agung Semarang',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Bus Pariwisata (AC, Audio, Reclining Seat)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan (Tol, Parkir, dll)'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral 600ml'],
                ],
            ],

            // ========== 8. KARIMUNJAWA 3D2N ==========
            [
                'nama_paket' => 'Karimunjawa 3D2N (Hotel/Resort)',
                'harga_paket' => 2350000.00,
                'durasi' => '3 Hari 2 Malam',
                'note' => 'Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Tour Laut Karimunjawa (Snorkeling)',
                    'Tour Darat Karimunjawa',
                    'Pantai Karimunjawa',
                    'Spot Sunset Karimunjawa',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Tiket Kapal Express Bahari PP'],
                    ['tipe' => 'transportasi', 'nama' => 'Transportasi Lokal Karimunjawa'],
                    ['tipe' => 'akomodasi', 'nama' => 'Homestay / Hotel AC (2 Malam)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Guide & Dokumentasi'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Destinasi'],
                    ['tipe' => 'akomodasi', 'nama' => 'Alat Snorkeling'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Selama Tour'],
                    ['tipe' => 'konsumsi', 'nama' => 'BBQ di Pulau'],
                ],
            ],

            // ========== 9. OUTBOUND ==========
            [
                'nama_paket' => 'Outbound Baturaden',
                'harga_paket' => 100000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk minimal 100 siswa. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Baturaden',
                    'Curug Bayan',
                    'Ketenger',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'Mobil Dalmas'],
                    ['tipe' => 'akomodasi', 'nama' => 'Trainer / Fasilitator'],
                    ['tipe' => 'akomodasi', 'nama' => 'HTM (Harga Tiket Masuk)'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan 1x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack 1x'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral 600ml 1x'],
                ],
            ],

            // ========== 10. TRIP DIENG ONE DAY ==========
            [
                'nama_paket' => 'Trip Dieng One Day',
                'harga_paket' => 425000.00,
                'durasi' => '1 Hari',
                'note' => 'Harga untuk 20 PAX menggunakan ELF. Harga sewaktu-waktu bisa berubah.',
                'destinasis' => [
                    'Telaga Menjer',
                    'Candi Arjuna Dieng',
                    'Gunung Prau / Sikunir',
                ],
                'fasilitas' => [
                    ['tipe' => 'transportasi', 'nama' => 'ELF (AC, Audio)'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tour Leader'],
                    ['tipe' => 'akomodasi', 'nama' => 'Tiket Masuk Objek Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'P3K + Asuransi Wisata'],
                    ['tipe' => 'akomodasi', 'nama' => 'Retribusi Perjalanan'],
                    ['tipe' => 'konsumsi', 'nama' => 'Makan Sesuai Program'],
                    ['tipe' => 'konsumsi', 'nama' => 'Snack'],
                    ['tipe' => 'konsumsi', 'nama' => 'Air Mineral 330ml'],
                ],
            ],
        ];

        foreach ($pakets as $paketData) {
            $paketImage = $this->createDummyImage($paketData['nama_paket'], 'paket');

            $paketId = DB::table('pakets')->insertGetId([
                'nama_paket'  => $paketData['nama_paket'],
                'harga_paket' => $paketData['harga_paket'],
                'durasi'      => $paketData['durasi'],
                'note'        => $paketData['note'],
                'image'       => $paketImage,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            foreach ($paketData['destinasis'] as $namaDestinasi) {
                $destImage = $this->createDummyImage($namaDestinasi, 'destinasi');

                $destinasiId = DB::table('destinasis')->insertGetId([
                    'nama_destinasi' => $namaDestinasi,
                    'id_paket'       => $paketId,
                    'image'          => $destImage,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // Create a gallery entry for additional photos
                DB::table('galleries')->insert([
                    'id_destinasi' => $destinasiId,
                    'path'         => $destImage,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            foreach ($paketData['fasilitas'] as $fasilitas) {
                $fasImage = $this->createDummyImage($fasilitas['nama'], 'fasilitas');

                DB::table('fasilitas')->insert([
                    'tipe_fasilitas' => strtolower($fasilitas['tipe']),
                    'nama_fasilitas' => $fasilitas['nama'],
                    'id_paket'       => $paketId,
                    'image'          => $fasImage,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
