document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('adminModal');
    if (!modal) return;

    const title = document.getElementById('adminModalTitle');
    const message = document.getElementById('adminModalMessage');
    const icon = document.getElementById('adminModalIcon');
    const cancel = modal.querySelector('[data-admin-modal-cancel]');
    const confirm = modal.querySelector('[data-admin-modal-confirm]');
    const closeButtons = modal.querySelectorAll('[data-admin-modal-close]');
    let pendingForm = null;

    function openModal({ type = 'success', titleText, messageText, confirmText = 'Konfirmasi', showCancel = false, form = null }) {
        pendingForm = form;
        title.textContent = titleText;
        message.textContent = messageText;
        confirm.textContent = confirmText;
        confirm.disabled = false;
        cancel.hidden = !showCancel;
        confirm.hidden = !form && type === 'success';
        icon.className = `admin-modal__icon admin-modal__icon--${type}`;
        icon.innerHTML = type === 'danger'
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6 6 18M6 6l12 12"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m5 12 4 4L19 6"/></svg>';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        pendingForm?.classList.remove('is-confirm-pending');
        pendingForm = null;
        confirm.disabled = false;
    }

    document.querySelectorAll('[data-admin-flash]').forEach((flash) => {
        openModal({
            type: flash.dataset.adminFlash === 'error' ? 'danger' : 'success',
            titleText: flash.dataset.adminFlash === 'error' ? 'Terjadi Kesalahan' : 'Berhasil',
            messageText: flash.textContent.trim(),
        });
        flash.remove();
    });

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('form[data-confirm]');
        if (!form || form.dataset.confirmed === 'true') return;
        event.preventDefault();
        form.classList.add('is-confirm-pending');

        openModal({
            type: 'danger',
            titleText: form.dataset.confirmTitle || 'Apakah anda yakin?',
            messageText: form.dataset.confirmMessage || 'Data akan hilang dan tidak bisa dikembalikan',
            confirmText: form.dataset.confirmText || 'Konfirmasi',
            showCancel: true,
            form,
        });
    });

    confirm.addEventListener('click', () => {
        if (!pendingForm) {
            closeModal();
            return;
        }
        confirm.disabled = true;
        confirm.textContent = 'Memproses...';
        pendingForm.dataset.confirmed = 'true';
        pendingForm.submit();
    });

    cancel.addEventListener('click', closeModal);
    closeButtons.forEach((button) => button.addEventListener('click', closeModal));
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
});
