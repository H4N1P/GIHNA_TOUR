{{-- Global Lightbox Component --}}
<style>
    #lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(0, 0, 0, .88);
    }

    #lightbox.open {
        display: flex;
    }

    #lightbox-inner {
        display: flex;
        max-width: 100%;
        max-height: 100%;
        align-items: center;
        justify-content: center;
    }

    #lightbox-img,
    #lightbox-video {
        max-width: min(90vw, 1100px);
        max-height: 82vh;
        border-radius: 12px;
        object-fit: contain;
    }

    #lightbox-close {
        position: absolute;
        top: 24px;
        right: 32px;
        z-index: 10;
        display: inline-flex;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        color: #fff;
        cursor: pointer;
        font-size: 32px;
        font-weight: 300;
        line-height: 1;
    }

    #lightbox-close:hover {
        color: var(--gold, #f59e0b);
    }

    #lightbox-ph {
        width: min(500px, 90vw);
        min-height: 280px;
        border-radius: 16px;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;
    }
</style>

<div id="lightbox" onclick="handleLightboxBackdrop(event)">
    <button id="lightbox-close" type="button" onclick="closeLightbox()" aria-label="Tutup preview">&times;</button>
    <div id="lightbox-inner" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" style="display:none;" />
        <video id="lightbox-video" controls style="display:none;">
            <source id="lightbox-video-src" src="" type="video/mp4">
        </video>
        <div id="lightbox-ph">
            <svg id="lightbox-icon" style="width:48px;height:48px;color:rgba(255,255,255,0.5);" fill="currentColor"
                viewBox="0 0 24 24">
                <path
                    d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
            </svg>
            <p id="lightbox-label2" style="color:rgba(255,255,255,0.8);font-size:15px;font-weight:600;"></p>
            <p style="color:rgba(255,255,255,0.5);font-size:12px;">Dokumentasi tour</p>
        </div>
    </div>
</div>

<script>
    function openLightbox(src, label, isVideo = false) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const video = document.getElementById('lightbox-video');
        const videoSrc = document.getElementById('lightbox-video-src');
        const ph = document.getElementById('lightbox-ph');
        const label2 = document.getElementById('lightbox-label2');

        img.style.display = 'none';
        img.removeAttribute('src');
        video.pause();
        video.style.display = 'none';
        videoSrc.removeAttribute('src');
        ph.style.display = 'none';

        if (src && isVideo) {
            videoSrc.src = src;
            video.load();
            video.style.display = 'block';
        } else if (src) {
            img.src = src;
            img.style.display = 'block';
        } else {
            ph.style.display = 'flex';
            ph.style.background = 'rgba(255,255,255,.08)';
            ph.style.border = '1px solid rgba(255,255,255,.15)';
        }

        label2.textContent = label || 'Galeri';
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const video = document.getElementById('lightbox-video');
        const videoSrc = document.getElementById('lightbox-video-src');

        video.pause();
        videoSrc.removeAttribute('src');
        video.load();
        img.removeAttribute('src');
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleLightboxBackdrop(event) {
        if (event.target === event.currentTarget) {
            closeLightbox();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
