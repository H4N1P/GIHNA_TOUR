{{-- Global Lightbox Component --}}
<style>
    #lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .88);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    #lightbox.open {
        display: flex;
    }

    #lightbox-img {
        max-width: 80vw;
        max-height: 80vh;
        border-radius: 12px;
        object-fit: contain;
    }

    #lightbox-video {
        max-width: 80vw;
        max-height: 80vh;
        border-radius: 12px;
    }

    #lightbox-close {
        position: absolute;
        top: 24px;
        right: 32px;
        font-size: 32px;
        color: #fff;
        cursor: pointer;
        font-weight: 300;
        line-height: 1;
        z-index: 10;
    }

    #lightbox-close:hover {
        color: var(--gold, #f59e0b);
    }
</style>

<div id="lightbox" onclick="closeLightbox()">
    <span id="lightbox-close" onclick="closeLightbox()">×</span>
    <div id="lightbox-inner"
        style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;"
        onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" style="display:none;" />
        <video id="lightbox-video" controls style="display:none;">
            <source id="lightbox-video-src" src="" type="video/mp4">
        </video>
        <div id="lightbox-ph"
            style="width:500px;height:350px;border-radius:16px;display:none;align-items:center;justify-content:center;flex-direction:column;gap:10px;">
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

        // Reset
        img.style.display = 'none';
        video.style.display = 'none';
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
        const video = document.getElementById('lightbox-video');
        video.pause();
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
