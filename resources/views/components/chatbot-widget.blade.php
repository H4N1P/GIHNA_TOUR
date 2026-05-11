@props([
    'mode' => 'public',
    'menuUrl' => route('public-chatbot.menu'),
    'messageUrl' => route('public-chatbot.message'),
])

<button
    id="chatbotTrigger"
    class="chatbot-trigger"
    type="button"
    title="Ghina Assistant"
    aria-label="Buka Ghina Assistant">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z"/>
    </svg>
</button>

<section
    id="chatbotContainer"
    class="chatbot-container"
    data-menu-url="{{ $menuUrl }}"
    data-message-url="{{ $messageUrl }}"
    data-mode="{{ $mode }}"
    aria-label="Ghina Assistant">
    <header class="chatbot-header">
        <div class="chatbot-brand-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3a4 4 0 0 0-4 4v1H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-2V7a4 4 0 0 0-4-4Zm-2 5V7a2 2 0 1 1 4 0v1h-4Zm-2 5h2v2H8v-2Zm4 0h2v2h-2v-2Z"/>
            </svg>
        </div>
        <div>
            <h3>Ghina Assistant</h3>
            <p>Always Online</p>
        </div>
        <button id="chatbotClose" class="chatbot-close" type="button" aria-label="Tutup chatbot">&times;</button>
    </header>

    <div id="chatbotMessages" class="chatbot-messages">
        <div class="chatbot-day">Hari Ini</div>
    </div>

    <form id="chatbotForm" class="chatbot-input-area">
        <input id="chatbotInput" class="chatbot-input" type="text" placeholder="Ketik pesan anda..." autocomplete="off">
        <button id="chatbotSend" class="chatbot-send" type="submit" aria-label="Kirim pesan">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2 .01 7Z"/>
            </svg>
        </button>
    </form>
</section>
