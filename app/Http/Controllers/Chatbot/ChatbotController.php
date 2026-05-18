<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Handle public chatbot messages
     */
    public function handlePublicMessage(Request $request): JsonResponse
    {
        try {
            $userMessage = trim($request->input('message', ''));

            if ($userMessage === '') {
                return response()->json([
                    'success' => false,
                    'response' => 'Mohon masukkan pesan Anda.'
                ]);
            }

            // Let AI handle the public message completely
            $aiResponse = $this->callGemini($userMessage);

            return response()->json([
                'success' => true,
                'response' => $aiResponse
            ]);
        } catch (\Exception $e) {
            Log::error('Public Chatbot Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.'
            ]);
        }
    }

    /**
     * Get initial greeting menu for public
     */
    public function getPublicMenu(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'response' => "Halo! Selamat datang di **Ghina Tour & Travel**. Saya adalah asisten virtual cerdas Anda.\n\nAnda bebas bertanya apa saja tentang harga, paket, atau rute perjalanan kami!",
            'options' => ['Rekomendasi Paket?', 'Paket Termurah', 'Tanya Admin']
        ]);
    }

    /**
     * Handle logged-in user / generic messages
     */
    public function handleMessage(Request $request): JsonResponse
    {
        try {
            $userMessage = trim($request->input('message', ''));
            $lowerMessage = strtolower($userMessage);

            if (empty($userMessage)) {
                return response()->json([
                    'success' => false,
                    'response' => 'Mohon masukkan pesan Anda.'
                ]);
            }

            // HYBRID: Keep the rule-based logic for specific structured lookups like Pesanan (Orders)
            // Because AI cannot guess order statuses unless we dump the entire order database into the prompt (not scalable).
            if (preg_match('/(?:cek|check|cari|pesanan)\s+(\d{8,15})/', $lowerMessage, $matches)) {
                return $this->handlePesananSearch($matches[1]);
            }

            if (preg_match('/\b(08\d{8,13})\b/', $lowerMessage, $matches)) {
                return $this->handlePesananSearch($matches[1]);
            }

            if ($this->containsKeyword($lowerMessage, ['menu', 'bantuan', 'help'])) {
                return $this->getMenu();
            }

            // For everything else, ask Gemini AI!
            $aiResponse = $this->callGemini($userMessage);

            return response()->json([
                'success' => true,
                'response' => $aiResponse
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
            'response' => "Halo! Selamat datang di **Ghina Assistant** 😊\n\nSaya adalah AI Assistant yang siap membantu Anda. Anda bisa bertanya tentang paket wisata kami atau mengecek status pesanan.\n\nContoh: *\"Cek pesanan 08123456789\"* atau *\"Berapa harga paket ke Jogja?\"*",
            'options' => ['Paket Populer', 'Cara Cek Pesanan', 'Kontak Admin']
        ]);
    }

    /**
     * Core AI Integration Logic
     */
    private function callGemini(string $message): string
    {
        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return "Sistem AI sedang dalam perbaikan (API Key tidak ditemukan). Silakan hubungi admin via WhatsApp.";
        }

        // 1. Gather Context Data from Database
        $company = CompanyProfile::first();
        $pakets = Paket::with(['fasilitas', 'destinasis'])->get();

        // 2. Build the System Prompt (RAG - Retrieval Augmented Generation)
        $context = "Anda adalah Customer Service cerdas dari agen travel 'Ghina Tour Travel'.\n";
        $context .= "Jawab pertanyaan pelanggan dengan ramah, sopan, profesional, ringkas, dan persuasif.\n";
        $context .= "Gunakan emoji yang relevan secukupnya. Jangan pernah berhalusinasi atau mengarang harga/paket yang tidak ada di dalam daftar di bawah ini. Jika ditanya hal di luar konteks travel/paket, arahkan kembali dengan sopan ke layanan Ghina Tour Travel.\n\n";

        $context .= "--- PROFIL PERUSAHAAN ---\n";
        if ($company) {
            $context .= "WhatsApp Admin: " . ($company->whatsapp ?: 'Belum diatur') . "\n";
            $context .= "Alamat: " . ($company->address ?: 'Belum diatur') . "\n";
            $context .= "Tentang Kami: " . ($company->about ?: 'Agen tour dan travel terpercaya.') . "\n\n";
        }

        $context .= "--- DAFTAR PAKET TOUR TERSEDIA ---\n";
        if ($pakets->isEmpty()) {
            $context .= "Saat ini belum ada paket yang tersedia.\n";
        } else {
            foreach ($pakets as $p) {
                $context .= "- Paket: {$p->nama_paket}\n";
                $context .= "  Durasi: {$p->durasi}\n";
                $context .= "  Harga: Rp " . number_format($p->harga_paket, 0, ',', '.') . "\n";
                if ($p->destinasis->isNotEmpty()) {
                    $context .= "  Tujuan: " . implode(', ', $p->destinasis->pluck('nama_destinasi')->toArray()) . "\n";
                }
                if ($p->note) {
                    $context .= "  Catatan Khusus: {$p->note}\n";
                }
            }
        }

        $context .= "\n\n--- PERTANYAAN PELANGGAN ---\n";
        $context .= $message . "\n";
        $context .= "--- \nTuliskan balasan Anda sekarang:";

        // 3. Make the API Call to Google Gemini
        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $context]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Maaf, saya tidak dapat memproses respons saat ini.";
            }

            Log::error('Gemini API Error Response: ' . $response->body());
            return "Maaf, sistem AI sedang mengalami gangguan koneksi. Silakan coba beberapa saat lagi.";

        } catch (\Exception $e) {
            Log::error('Gemini Request Exception: ' . $e->getMessage());
            return "Maaf, terjadi kesalahan koneksi internal ke server AI.";
        }
    }

    /**
     * Handle pesanan search by phone number (Kept from old logic for accuracy)
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
