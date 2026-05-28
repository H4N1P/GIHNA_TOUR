<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Services\Chatbot\GeminiChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(private readonly GeminiChatbotService $chatbot) {}

    public function handlePublicMessage(Request $request): JsonResponse
    {
        return $this->handleAiMessage($request, 'public', 'Public Chatbot Error');
    }

    public function getPublicMenu(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'response' => "Halo! Selamat datang di **Ghina Tour & Travel**.\n\nSaya adalah AI customer service yang bisa membantu tentang paket wisata, harga, fasilitas, kontak admin, dan status pesanan.",
            'options' => ['Rekomendasi Paket?', 'Paket Termurah', 'Tanya Admin'],
        ]);
    }

    private function handleAiMessage(Request $request, string $audience, string $logContext): JsonResponse
    {
        try {
            $userMessage = trim((string) $request->input('message', ''));

            if ($userMessage === '') {
                return response()->json([
                    'success' => false,
                    'response' => 'Mohon masukkan pesan Anda.',
                ]);
            }

            return response()->json([
                'success' => true,
                'response' => $this->chatbot->reply($userMessage, $audience),
            ]);
        } catch (\Throwable $e) {
            Log::error($logContext . ': ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'success' => false,
                'response' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti.',
            ]);
        }
    }
}
