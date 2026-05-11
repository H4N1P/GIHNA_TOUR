document.addEventListener('DOMContentLoaded', () => {
    const trigger = document.getElementById('chatbotTrigger');
    const container = document.getElementById('chatbotContainer');
    const closeBtn = document.getElementById('chatbotClose');
    const form = document.getElementById('chatbotForm');
    const input = document.getElementById('chatbotInput');
    const messages = document.getElementById('chatbotMessages');

    if (!trigger || !container || !form || !input || !messages) return;

    const menuUrl = container.dataset.menuUrl;
    const messageUrl = container.dataset.messageUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    trigger.addEventListener('click', () => {
        container.classList.toggle('active');
        if (container.classList.contains('active')) {
            input.focus();
            if (!messages.dataset.loaded) fetchInitialMenu();
        }
    });

    closeBtn?.addEventListener('click', () => container.classList.remove('active'));

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        sendMessage(input.value);
    });

    async function sendMessage(text) {
        if (!text.trim()) return;

        appendMessage(text, 'user');
        input.value = '';
        showTyping();

        try {
            const response = await fetch(messageUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await response.json();
            hideTyping();
            appendMessage(data.response || 'Tidak ada respons.', 'bot', data.options || []);
        } catch (error) {
            hideTyping();
            appendMessage('Terjadi kesalahan koneksi.', 'bot');
        }
    }

    async function fetchInitialMenu() {
        showTyping();
        try {
            const response = await fetch(menuUrl, { headers: { 'Accept': 'application/json' } });
            const data = await response.json();
            hideTyping();
            if (data.success) {
                appendMessage(data.response, 'bot', data.options || []);
                messages.dataset.loaded = 'true';
            }
        } catch (error) {
            hideTyping();
            appendMessage('Gagal memuat menu.', 'bot');
        }
    }

    function appendMessage(text, side, options = []) {
        const message = document.createElement('div');
        message.className = `message message-${side}`;
        message.innerHTML = `<div>${formatMessage(text)}</div>`;

        if (options.length > 0) {
            const replies = document.createElement('div');
            replies.className = 'quick-replies';
            options.forEach((option) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'quick-reply-btn';
                button.textContent = option;
                button.addEventListener('click', () => sendMessage(option));
                replies.appendChild(button);
            });
            message.appendChild(replies);
        }

        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    }

    function formatMessage(text) {
        const escaped = String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;');

        return escaped
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
    }

    function showTyping() {
        const typing = document.createElement('div');
        typing.className = 'message message-bot typing-indicator';
        typing.id = 'typingIndicator';
        typing.innerHTML = '<div class="typing"><span></span><span></span><span></span></div>';
        messages.appendChild(typing);
        messages.scrollTop = messages.scrollHeight;
    }

    function hideTyping() {
        document.getElementById('typingIndicator')?.remove();
    }
});
