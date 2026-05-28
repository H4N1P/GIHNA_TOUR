@props([
    'mode' => 'public',
    'menuUrl' => route('public-chatbot.menu'),
    'messageUrl' => route('public-chatbot.message'),
])

<?php
    try {
        $companyProfile = \App\Models\CompanyProfile::query()->first();
        $whatsapp = $companyProfile->whatsapp ?? '6281234567890';
    } catch (\Throwable) {
        $whatsapp = '6281234567890';
    }

    $waLink = "https://wa.me/" . preg_replace('/\D/', '', $whatsapp);
?>

<div class="chatbot-root fixed bottom-4 right-4 z-50 max-w-[calc(100vw-2rem)] sm:bottom-6 sm:right-6">
    <button
        id="chatbotTrigger"
        class="chatbot-trigger flex h-14 w-14 shrink-0 items-center justify-center rounded-full shadow-lg"
        type="button"
        title="GhinaTour"
        aria-label="Buka GhinaTour">
        <span class="chatbot-trigger__label">GhinaTour</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z"/>
        </svg>
    </button>

    <section
        id="chatbotContainer"
        class="chatbot-container absolute bottom-20 right-0 flex h-[70dvh] max-h-[640px] min-h-[420px] w-[calc(100vw-2rem)] max-w-sm flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:w-96"
        data-menu-url="{{ $menuUrl }}"
        data-message-url="{{ $messageUrl }}"
        data-mode="{{ $mode }}"
        data-wa="{{ $waLink }}"
        aria-label="GhinaTour">
        <header class="chatbot-header shrink-0">
            <div class="chatbot-brand-icon shrink-0" aria-hidden="true">
                <img src="{{ asset('customer/assets/images/logos/logo.png') }}" alt="">
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="truncate">GhinaTour</h3>
                <p class="truncate">Always Online</p>
            </div>
            <button id="chatbotClose" class="chatbot-close shrink-0" type="button" aria-label="Tutup chatbot">&times;</button>
        </header>

        <main id="chatbotMessages" class="chatbot-messages min-h-0 flex-1 overflow-y-auto">
            <div class="chatbot-day">Hari Ini</div>
        </main>

        <form id="chatbotForm" class="chatbot-input-area shrink-0">
            <input id="chatbotInput" class="chatbot-input min-w-0 flex-1" type="text" placeholder="Ketik pesan anda..." autocomplete="off">
            <button id="chatbotSend" class="chatbot-send shrink-0" type="submit" aria-label="Kirim pesan">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/>
                </svg>
            </button>
        </form>
    </section>
</div>
