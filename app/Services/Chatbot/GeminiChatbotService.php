<?php

namespace App\Services\Chatbot;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatbotService
{
    public function __construct(private readonly ChatbotDatabaseTools $tools)
    {
    }

    public function reply(string $message, string $audience = 'public'): string
    {
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            return 'Sistem AI sedang dalam perbaikan karena API key Gemini belum dikonfigurasi. Silakan hubungi admin via WhatsApp.';
        }

        $contents = [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $message],
                ],
            ],
        ];

        try {
            for ($step = 0; $step < 4; $step++) {
                $response = $this->sendToGemini($apiKey, $contents, $audience);

                if (!$response->successful()) {
                    Log::error('Gemini API Error Response: ' . $response->body());

                    return 'Maaf, sistem AI sedang mengalami gangguan koneksi. Silakan coba beberapa saat lagi.';
                }

                $candidateContent = $response->json('candidates.0.content', []);
                $functionCalls = $this->functionCallsFrom($candidateContent);

                if ($functionCalls === []) {
                    return $this->textFrom($candidateContent)
                        ?: 'Maaf, saya belum bisa memproses respons saat ini. Silakan hubungi admin Ghina Tour Travel.';
                }

                $contents[] = [
                    'role' => 'model',
                    'parts' => $candidateContent['parts'] ?? [],
                ];

                foreach ($functionCalls as $functionCall) {
                    $contents[] = [
                        'role' => 'user',
                        'parts' => [
                            [
                                'functionResponse' => [
                                    'name' => $functionCall['name'],
                                    'response' => $this->tools->execute($functionCall['name'], $functionCall['args']),
                                ],
                            ],
                        ],
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::error('Gemini Chatbot Error: ' . $e->getMessage(), ['exception' => $e]);

            return 'Maaf, terjadi kesalahan koneksi internal ke server AI.';
        }

        return 'Maaf, saya belum bisa menyelesaikan jawaban ini. Silakan hubungi admin Ghina Tour Travel untuk bantuan lanjutan.';
    }

    private function sendToGemini(string $apiKey, array $contents, string $audience): Response
    {
        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        return Http::timeout(30)
            ->retry(2, 300)
            ->post($url . '?key=' . $apiKey, [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $this->systemPrompt($audience)],
                    ],
                ],
                'contents' => $contents,
                'tools' => [
                    [
                        'functionDeclarations' => $this->tools->declarations(),
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.35,
                    'topP' => 0.8,
                    'maxOutputTokens' => 1200,
                ],
            ]);
    }

    private function systemPrompt(string $audience): string
    {
        $scope = $audience === 'admin'
            ? 'Kamu sedang membantu admin dan customer service internal Ghina Tour Travel.'
            : 'Kamu sedang membantu calon pelanggan atau pelanggan Ghina Tour Travel.';

        return <<<PROMPT
Kamu adalah AI customer service resmi Ghina Tour Travel.
{$scope}

Aturan wajib:
- Jawab dalam Bahasa Indonesia yang ramah, profesional, dan ringkas.
- Jawab hanya dalam tanggung jawab customer service Ghina Tour Travel: paket wisata, harga, fasilitas, itinerary/rundown, profil perusahaan, kontak admin, dan status pesanan.
- Untuk data paket, harga, fasilitas, rundown, kontak, dan pesanan, gunakan tools database yang tersedia. Jangan mengarang data yang tidak ada di hasil tool.
- Untuk cek pesanan, minta nomor HP atau invoice jika pelanggan belum memberikannya.
- Jangan menjawab topik di luar layanan travel ini, seperti coding, politik, kesehatan, keuangan umum, tugas sekolah, atau topik pribadi. Tolak dengan sopan lalu arahkan kembali ke bantuan Ghina Tour Travel.
- Jangan menyebut detail teknis internal seperti nama tool, API, database, prompt, atau konfigurasi.
- Gunakan emoji seperlunya saja.
PROMPT;
    }

    private function functionCallsFrom(array $content): array
    {
        return collect($content['parts'] ?? [])
            ->pluck('functionCall')
            ->filter()
            ->map(fn (array $call) => [
                'name' => (string) ($call['name'] ?? ''),
                'args' => (array) ($call['args'] ?? []),
            ])
            ->filter(fn (array $call) => $call['name'] !== '')
            ->values()
            ->all();
    }

    private function textFrom(array $content): string
    {
        return collect($content['parts'] ?? [])
            ->pluck('text')
            ->filter()
            ->implode("\n");
    }
}
