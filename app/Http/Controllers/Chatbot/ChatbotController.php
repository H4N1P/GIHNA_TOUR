<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handlePublicMessage(Request $request): JsonResponse
    {
        try {
            $userMessage = strtolower(trim($request->input('message', '')));

            if ($userMessage === '') {
                return response()->json([
                    'success' => false,
                    'response' => 'Mohon masukkan pesan Anda.'
                ]);
            }

            if ($this->containsKeyword($userMessage, ['best seller', 'bestseller', 'terlaris'])) {
                return $this->handlePublicPaketQuery(limit: 3, intro: 'Untuk Paket Best Seller, berikut pilihan yang bisa Anda cek:');
            }

            if ($this->containsKeyword($userMessage, ['termurah', 'murah', 'harga'])) {
                return $this->handlePublicPaketQuery(sort: 'price_asc', limit: 3, intro: 'Berikut paket dengan harga paling terjangkau:');
            }

            if ($this->containsKeyword($userMessage, ['promo', 'lebaran'])) {
                return response()->json([
                    'success' => true,
                    'response' => "Promo terbaru dapat berubah sewaktu-waktu. Silakan hubungi admin lewat WhatsApp untuk penawaran paling akurat.",
                    'options' => ['Paket Best Seller', 'Paket Termurah', 'Tanya Admin']
                ]);
            }

            if ($this->containsKeyword($userMessage, ['admin', 'kontak', 'whatsapp', 'wa', 'tanya'])) {
                $company = CompanyProfile::first();
                $phone = $company?->whatsapp ?: '081234567890';
                return response()->json([
                    'success' => true,
                    'response' => "Anda bisa menghubungi admin Ghina Tour Travel melalui WhatsApp: **{$phone}**."
                ]);
            }

            if ($this->containsKeyword($userMessage, ['paket', 'tour', 'wisata', 'perjalanan', 'trip'])) {
                return $this->handlePublicPaketQuery(limit: 5);
            }

            if ($this->containsKeyword($userMessage, ['profil', 'profile', 'company', 'tentang', 'alamat', 'email'])) {
                return $this->handleCompanyProfile();
            }

            return $this->getPublicMenu();
        } catch (\Exception $e) {
            Log::error('Public Chatbot Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            ]);
        }
    }

    public function getPublicMenu(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'response' => "Halo! Selamat datang di **Ghina Tour & Travel**. Ada yang bisa kami bantu hari ini?",
            'options' => ['Paket Best Seller', 'Promo Lebaran', 'Paket Termurah', 'Tanya Admin']
        ]);
    }

    /**
     * Handle incoming chatbot messages (rule-based, no AI key required)
     */
    public function handleMessage(Request $request): JsonResponse
    {
        try {
            $userMessage = strtolower(trim($request->input('message', '')));

            if (empty($userMessage)) {
                return response()->json([
                    'success' => false,
                    'response' => 'Mohon masukkan pesan Anda.'
                ]);
            }

            // Route message to appropriate handler based on keywords
            if ($this->containsKeyword($userMessage, ['paket', 'tour', 'wisata', 'perjalanan', 'trip'])) {
                return $this->handlePaketQuery($userMessage);
            }

            if ($this->containsKeyword($userMessage, ['pesanan', 'order', 'booking', 'invoice', 'status'])) {
                return response()->json([
                    'success' => true,
                    'response' => "Untuk mengecek pesanan, silakan kirim nomor HP yang digunakan saat pemesanan.\n\nContoh: cek 08123456789"
                ]);
            }

            if (preg_match('/(?:cek|check|cari)\s+(\d{8,15})/', $userMessage, $matches)) {
                return $this->handlePesananSearch($matches[1]);
            }

            if (preg_match('/\b(08\d{8,13})\b/', $userMessage, $matches)) {
                return $this->handlePesananSearch($matches[1]);
            }

            if ($this->containsKeyword($userMessage, ['profil', 'profile', 'company', 'tentang', 'kontak', 'alamat', 'whatsapp', 'email'])) {
                return $this->handleCompanyProfile();
            }

            if ($this->containsKeyword($userMessage, ['menu', 'bantuan', 'help', 'halo', 'hai', 'hi', 'hello'])) {
                return $this->getMenu();
            }

            // Default response
            return response()->json([
                'success' => true,
                'response' => "Maaf, saya belum memahami pertanyaan Anda.\n\nSilakan pilih salah satu menu:\n📦 **Paket Tour** — Lihat daftar paket\n📋 **Pesanan** — Cek status pesanan\n🏢 **Profil** — Info perusahaan\n\nAtau ketik **menu** untuk melihat pilihan lengkap."
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            ]);
        }
    }

    /**
     * Get initial greeting menu
     */
    public function getMenu(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'response' => "Halo! Selamat datang di **Ghina Assistant** 😊\n\nSaya siap membantu Anda:\n\n📦 **Paket Tour** — Lihat daftar paket tour kami\n📋 **Pesanan** — Cek status pesanan Anda\n🏢 **Profil Perusahaan** — Info tentang kami\n\nSilakan ketik menu yang Anda inginkan atau ajukan pertanyaan langsung!",
            'options' => ['paket', 'pesanan', 'profil perusahaan']
        ]);
    }

    /**
     * Handle paket-related queries
     */
    private function handlePaketQuery(string $userMessage): JsonResponse
    {
        try {
            $pakets = Paket::with(['fasilitas', 'tempats'])->get();

            if ($pakets->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'response' => 'Maaf, belum ada paket tour yang tersedia saat ini.'
                ]);
            }

            $result = "📦 **DAFTAR PAKET TOUR:**\n\n";
            foreach ($pakets as $index => $paket) {
                $result .= "━━━━━━━━━━━━━━━━━━━━━━\n";
                $result .= "**" . ($index + 1) . ". {$paket->nama_paket}**\n";
                $result .= "💰 Harga: Rp " . number_format($paket->harga_paket, 0, ',', '.') . "\n";
                $result .= "⏱️ Durasi: {$paket->durasi}\n";

                if ($paket->fasilitas->isNotEmpty()) {
                    $fasilitas = $paket->fasilitas->pluck('nama_fasilitas')->toArray();
                    $result .= "✅ Fasilitas: " . implode(', ', $fasilitas) . "\n";
                }

                if ($paket->tempats->isNotEmpty()) {
                    $tempats = $paket->tempats->pluck('nama_tempat')->toArray();
                    $result .= "📍 Tujuan: " . implode(', ', $tempats) . "\n";
                }

                if ($paket->note) {
                    $result .= "📝 Note: {$paket->note}\n";
                }
                $result .= "\n";
            }

            return response()->json([
                'success' => true,
                'response' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Get Pakets Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'response' => 'Terjadi kesalahan saat mengambil data paket tour.'
            ]);
        }
    }

    private function handlePublicPaketQuery(string $sort = 'latest', int $limit = 5, ?string $intro = null): JsonResponse
    {
        $query = Paket::query();

        if ($sort === 'price_asc') {
            $query->orderBy('harga_paket');
        } else {
            $query->latest();
        }

        $pakets = $query->take($limit)->get();

        if ($pakets->isEmpty()) {
            return response()->json([
                'success' => true,
                'response' => 'Maaf, belum ada paket tour yang tersedia saat ini.'
            ]);
        }

        $result = ($intro ?: 'Berikut beberapa paket wisata Ghina Tour Travel:') . "\n\n";
        foreach ($pakets as $paket) {
            $result .= "**{$paket->nama_paket}**\n";
            $result .= "Durasi: {$paket->durasi}\n";
            $result .= "Harga: Rp " . number_format($paket->harga_paket, 0, ',', '.') . "/pax\n\n";
        }
        $result .= "Info lengkapnya bisa langsung cek halaman paket atau tanya admin.";

        return response()->json([
            'success' => true,
            'response' => $result,
            'options' => ['Paket Best Seller', 'Promo Lebaran', 'Paket Termurah', 'Tanya Admin']
        ]);
    }

    /**
     * Handle pesanan search by phone number
     */
    private function handlePesananSearch(string $noHp): JsonResponse
    {
        try {
            $cleanNoHp = preg_replace('/[^0-9]/', '', $noHp);

            $pesanans = Pesanan::with('paket')
                ->where('no_hp', 'like', '%' . $cleanNoHp . '%')
                ->latest()
                ->take(10)
                ->get();

            if ($pesanans->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'response' => "Maaf, tidak ada pesanan yang ditemukan dengan nomor HP **{$noHp}**.\n\nPastikan nomor HP yang dimasukkan benar."
                ]);
            }

            $result = "📋 **DAFTAR PESANAN:**\n\n";
            foreach ($pesanans as $index => $pesanan) {
                $result .= "━━━━━━━━━━━━━━━━━━━━━━\n";
                $result .= "**Pesanan #" . ($index + 1) . "**\n";
                $result .= "👤 Pemesan: {$pesanan->nama_pemesan}\n";
                $result .= "📦 Paket: " . ($pesanan->paket ? $pesanan->paket->nama_paket : 'N/A') . "\n";
                $result .= "📅 Tanggal: " . \Carbon\Carbon::parse($pesanan->tanggal_acara)->format('d F Y') . "\n";
                $result .= "👥 Jumlah: {$pesanan->jumlah_orang} pax\n";
                $result .= "💰 Total: Rp " . number_format($pesanan->total_harga, 0, ',', '.') . "\n";

                if ($pesanan->invoice) {
                    $result .= "📄 Invoice: {$pesanan->invoice}\n";
                }

                $status = $pesanan->status ?? 'Menunggu Konfirmasi';
                $result .= "✅ Status: " . ucfirst($status) . "\n\n";
            }

            return response()->json([
                'success' => true,
                'response' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Search Pesanan Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'response' => 'Terjadi kesalahan saat mencari pesanan.'
            ]);
        }
    }

    /**
     * Handle company profile query
     */
    private function handleCompanyProfile(): JsonResponse
    {
        try {
            $company = CompanyProfile::first();

            if (!$company) {
                return response()->json([
                    'success' => true,
                    'response' => 'Maaf, informasi profil perusahaan belum tersedia.'
                ]);
            }

            $result = "🏢 **PROFIL GHINA TOUR TRAVEL**\n\n";

            if ($company->about) {
                $result .= "**Tentang Kami:**\n{$company->about}\n\n";
            }

            if ($company->vision_mission) {
                $result .= "**Visi & Misi:**\n{$company->vision_mission}\n\n";
            }

            $result .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $result .= "📞 **KONTAK KAMI**\n\n";

            if ($company->whatsapp) {
                $result .= "📱 WhatsApp: {$company->whatsapp}\n";
            }
            if ($company->email) {
                $result .= "📧 Email: {$company->email}\n";
            }
            if ($company->address) {
                $result .= "📍 Alamat: {$company->address}\n";
            }
            if ($company->instagram) {
                $result .= "📸 Instagram: {$company->instagram}\n";
            }

            return response()->json([
                'success' => true,
                'response' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Get Company Profile Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'response' => 'Terjadi kesalahan saat mengambil profil perusahaan.'
            ]);
        }
    }

    /**
     * Check if message contains any of the given keywords
     */
    private function containsKeyword(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
