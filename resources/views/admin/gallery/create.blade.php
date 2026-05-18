@extends('components.layout.admin')
@section('title', 'Upload Media Galeri')
@section('header', 'Upload Media Galeri')

@section('content')
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
        @csrf

        {{-- Upload Area --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center gap-3">
                <a href="{{ route('admin.gallery.index') }}"
                    class="p-2 rounded-lg text-admin-muted hover:text-admin-text hover:bg-admin-bg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h3 class="text-lg font-semibold">Upload Media</h3>
            </div>
            <div class="p-4 lg:p-6">
                {{-- Dropzone --}}
                <div id="dropzone"
                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-admin-border border-dashed rounded-xl cursor-pointer bg-admin-bg hover:bg-admin-bg transition-colors"
                    onclick="document.getElementById('media').click()"
                    ondragover="event.preventDefault(); this.classList.add('border-amber-500','bg-amber-50')"
                    ondragleave="this.classList.remove('border-amber-500','bg-amber-50')" ondrop="handleDrop(event)">
                    <svg class="w-10 h-10 mb-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-medium text-admin-text">Klik atau drag & drop file di sini</p>
                    <p class="text-xs text-admin-muted mt-1">Foto (JPG, PNG, GIF, SVG, WebP) & Video (MP4, MOV, AVI) — Maks. 50MB per file</p>
                </div>
                <input type="file" name="media[]" id="media" multiple accept="image/*,video/*" class="hidden"
                    onchange="previewMedia(this)">

                @error('media')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('media.*')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror

                {{-- Preview Grid --}}
                <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4"></div>
            </div>
        </div>

        {{-- Relasi --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border">
                <h3 class="text-lg font-semibold">Relasi Media</h3>
                <p class="text-sm text-admin-muted mt-1">Kaitkan media dengan paket, destinasi wisata, atau fasilitas</p>
            </div>
            <div class="p-4 lg:p-6 space-y-4">
                {{-- Pilih Paket --}}
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">Paket Tour <span class="text-xs text-neutral-400">(pilih dulu untuk filter destinasi/fasilitas)</span></label>
                    <select id="paketSelect"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 text-admin-text focus:ring-2 focus:ring-amber-500 transition-colors">
                        <option value="">-- Pilih Paket --</option>
                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id }}">{{ $paket->nama_paket }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Pilih Destinasi --}}
                    <div>
                        <label class="block text-sm font-medium text-admin-text mb-2">Destinasi Wisata</label>
                        <select name="id_destinasi" id="destinasiSelect" disabled
                            class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-bg text-admin-text focus:ring-2 focus:ring-amber-500 transition-colors disabled:opacity-50">
                            <option value="">-- Pilih paket terlebih dahulu --</option>
                        </select>
                        @error('id_destinasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Pilih Fasilitas --}}
                    <div>
                        <label class="block text-sm font-medium text-admin-text mb-2">Fasilitas <span class="text-xs text-neutral-400">(opsional)</span></label>
                        <select name="id_fasilitas" id="fasilitasSelect" disabled
                            class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-bg text-admin-text focus:ring-2 focus:ring-amber-500 transition-colors disabled:opacity-50">
                            <option value="">-- Pilih paket terlebih dahulu --</option>
                        </select>
                        @error('id_fasilitas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.gallery.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-admin-text hover:bg-admin-bg rounded-lg transition-colors">Batal</a>
            <button type="submit"
                class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                Upload Media
            </button>
        </div>
    </form>

    <script>
        // === Dependent Dropdown via AJAX ===
        const paketSelect = document.getElementById('paketSelect');
        const destinasiSelect = document.getElementById('destinasiSelect');
        const fasilitasSelect = document.getElementById('fasilitasSelect');

        paketSelect.addEventListener('change', async function() {
            const paketId = this.value;

            // Reset dropdowns
            destinasiSelect.innerHTML = '<option value="">-- Tidak dikaitkan --</option>';
            fasilitasSelect.innerHTML = '<option value="">-- Tidak dikaitkan --</option>';

            if (!paketId) {
                destinasiSelect.disabled = true;
                fasilitasSelect.disabled = true;
                destinasiSelect.classList.add('opacity-50');
                fasilitasSelect.classList.add('opacity-50');
                return;
            }

            try {
                const res = await fetch(`{{ url('admin/api/gallery/relations') }}?paket_id=${paketId}`);
                const data = await res.json();

                // Populate Destinasi
                data.destinasis.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t.id;
                    opt.textContent = t.nama;
                    destinasiSelect.appendChild(opt);
                });

                // Populate Fasilitas
                data.fasilitas.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.id;
                    opt.textContent = f.nama;
                    fasilitasSelect.appendChild(opt);
                });

                destinasiSelect.disabled = false;
                fasilitasSelect.disabled = false;
                destinasiSelect.classList.remove('opacity-50');
                fasilitasSelect.classList.remove('opacity-50');
            } catch (err) {
                console.error('Failed to load relations:', err);
            }
        });

        // === Preview Media with Individual Removal ===
        // We keep a managed list of files using DataTransfer
        let selectedFiles = new DataTransfer();

        function syncFileInput() {
            const input = document.getElementById('media');
            input.files = selectedFiles.files;
        }

        function addFiles(fileList) {
            Array.from(fileList).forEach(file => {
                selectedFiles.items.add(file);
            });
            syncFileInput();
            renderPreviews();
        }

        function removeFile(index) {
            const newDt = new DataTransfer();
            const files = selectedFiles.files;
            for (let i = 0; i < files.length; i++) {
                if (i !== index) newDt.items.add(files[i]);
            }
            selectedFiles = newDt;
            syncFileInput();
            renderPreviews();
        }

        function renderPreviews() {
            const grid = document.getElementById('preview-grid');
            grid.innerHTML = '';
            const files = selectedFiles.files;
            let imgCount = 0, vidCount = 0;

            Array.from(files).forEach((file, idx) => {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-lg overflow-hidden border border-admin-border group/item';

                // X button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'absolute top-1 right-1 z-10 w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover/item:opacity-100 transition-opacity shadow-lg hover:bg-red-600 cursor-pointer';
                removeBtn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>';
                removeBtn.onclick = (e) => { e.stopPropagation(); removeFile(idx); };
                div.appendChild(removeBtn);

                if (file.type.startsWith('image/')) {
                    imgCount++;
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        div.insertBefore(img, removeBtn);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    vidCount++;
                    const vidPlaceholder = document.createElement('div');
                    vidPlaceholder.className = 'w-full h-full bg-neutral-800 flex flex-col items-center justify-center gap-2';
                    vidPlaceholder.innerHTML = `
                        <svg class="w-10 h-10 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <p class="text-xs text-neutral-400 px-2 text-center truncate">${file.name}</p>`;
                    div.insertBefore(vidPlaceholder, removeBtn);
                }

                grid.appendChild(div);
            });

            // Update dropzone text
            const dropzone = document.getElementById('dropzone');
            if (files.length > 0) {
                const parts = [];
                if (imgCount > 0) parts.push(`${imgCount} foto`);
                if (vidCount > 0) parts.push(`${vidCount} video`);
                dropzone.innerHTML = `
                    <svg class="w-8 h-8 mb-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm font-medium text-amber-600">${parts.join(' & ')} dipilih</p>
                    <p class="text-xs text-admin-muted mt-1">Klik untuk menambah lagi</p>`;
            } else {
                dropzone.innerHTML = `
                    <svg class="w-10 h-10 mb-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-medium text-admin-text">Klik atau drag & drop file di sini</p>
                    <p class="text-xs text-admin-muted mt-1">Foto (JPG, PNG, GIF, SVG, WebP) & Video (MP4, MOV, AVI) — Maks. 50MB per file</p>`;
            }
        }

        // File input change handler — add new files, don't replace
        function previewMedia(input) {
            addFiles(input.files);
        }

        function handleDrop(event) {
            event.preventDefault();
            event.currentTarget.classList.remove('border-amber-500', 'bg-amber-50');
            addFiles(event.dataTransfer.files);
        }
    </script>
@endsection
