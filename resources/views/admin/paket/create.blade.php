@extends('components.layout.admin')
@section('title', 'Tambah Paket Tour')
@section('header', 'Tambah Paket Tour')

@section('content')
    <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf

        {{-- ── Informasi Paket ── --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border">
                <h3 class="text-lg font-semibold">Informasi Paket</h3>
                <p class="text-sm text-admin-muted mt-1">Nama, harga, durasi, dan catatan paket</p>
            </div>
            <div class="p-4 lg:p-6 space-y-4">

                <div>
                    <label for="nama_paket" class="block text-sm font-medium text-admin-text mb-2">
                        Nama Paket <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="Contoh: Paket Umroh Premium">
                    @error('nama_paket')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-admin-text mb-2">
                        Gambar / Cover Paket <span class="text-admin-muted text-xs font-normal">(Opsional)</span>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="harga_paket"
                            class="block text-sm font-medium text-admin-text mb-2">
                            Harga / Pax (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-admin-muted text-sm">Rp</span>
                            <input type="number" id="harga_paket" name="harga_paket" value="{{ old('harga_paket') }}"
                                required min="0" step="1000"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                placeholder="25000000">
                        </div>
                        @error('harga_paket')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="durasi" class="block text-sm font-medium text-admin-text mb-2">
                            Durasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="durasi" name="durasi" value="{{ old('durasi') }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                            placeholder="Contoh: 3 Hari 2 Malam">
                        @error('durasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <div>
                    <label for="note" class="block text-sm font-medium text-admin-text mb-2">
                        Catatan / Note
                    </label>
                    <textarea id="note" name="note" rows="3"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors resize-none"
                        placeholder="Harga sudah termasuk hotel, tiket PP, dll...">{{ old('note') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── Destinasi Wisata ── --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400">Destinasi Wisata</h3>
                    <p class="text-sm text-admin-muted mt-0.5">Daftar destinasi yang akan dikunjungi
                    </p>
                </div>
                <button type="button" onclick="addDestinasiField()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors border border-blue-200 dark:border-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Destinasi
                </button>
            </div>
            <div class="p-4 lg:p-6">
                <div id="destinasis-container" class="space-y-3">
                    <p id="destinasis-empty" class="text-sm text-admin-muted italic">Belum ada destinasi. Klik "+ Tambah Destinasi"
                        untuk menambahkan.</p>
                </div>
            </div>
        </div>

        {{-- ── Fasilitas ── --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Fasilitas</h3>
                    <p class="text-sm text-admin-muted mt-0.5">Konsumsi, akomodasi, dan transportasi
                    </p>
                </div>
                <button type="button" onclick="addFasilitasField()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors border border-green-200 dark:border-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Fasilitas
                </button>
            </div>
            <div class="p-4 lg:p-6">
                <div id="fasilitas-container" class="space-y-3">
                    <p id="fasilitas-empty" class="text-sm text-admin-muted italic">Belum ada fasilitas. Klik "+ Tambah
                        Fasilitas" untuk menambahkan.</p>
                </div>
            </div>
        </div>

        {{-- ── Rundown Detail ── --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-purple-600 dark:text-purple-400">Rundown Detail (Harian)</h3>
                    <p class="text-sm text-admin-muted mt-0.5">Jadwal harian kegiatan/acara paket tour</p>
                </div>
                <button type="button" onclick="addRundownField()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors border border-purple-200 dark:border-purple-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Rundown
                </button>
            </div>
            <div class="p-4 lg:p-6">
                <div id="rundowns-container" class="space-y-4">
                    <p id="rundowns-empty" class="text-sm text-admin-muted italic">Belum ada rundown. Klik "+ Tambah Rundown" untuk menambahkan.</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pb-4">
            <a href="{{ route('admin.paket.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-admin-text hover:bg-admin-bg rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                Simpan Paket
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function addDestinasiField(value = '') {
            const container = document.getElementById('destinasis-container');
            const empty = document.getElementById('destinasis-empty');
            if (empty) empty.remove();

            const index = container.querySelectorAll('.field-row').length;
            const div = document.createElement('div');
            div.className = 'field-row flex gap-3 items-center';
            div.innerHTML = `
        <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold flex items-center justify-center flex-shrink-0">${index + 1}</span>
        <input type="text" name="destinasis[${index}][nama_destinasi]" value="${value}"
            class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
            placeholder="Nama destinasi (contoh: Mekkah, Madinah)">
        <input type="file" name="destinasis[${index}][image]" accept="image/*" title="Upload Gambar Destinasi"
            class="w-48 px-3 py-2 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm">
        <button type="button" onclick="removeRow(this, 'destinasis-container', 'destinasis-empty', 'Belum ada destinasi. Klik &quot;+ Tambah Destinasi&quot; untuk menambahkan.')"
            class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>`;
            container.appendChild(div);
            renumberRows('destinasis-container');
        }

        function addFasilitasField(nama = '', tipe = 'konsumsi') {
            const container = document.getElementById('fasilitas-container');
            const empty = document.getElementById('fasilitas-empty');
            if (empty) empty.remove();

            const index = container.querySelectorAll('.field-row').length;
            const div = document.createElement('div');
            div.className = 'field-row flex gap-3 items-center';
            div.innerHTML = `
        <input type="text" name="fasilitas[${index}][nama_fasilitas]" value="${nama}"
            class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
            placeholder="Nama fasilitas (contoh: Hotel Bintang 5)">
        <input type="file" name="fasilitas[${index}][image]" accept="image/*" title="Upload Gambar Fasilitas"
            class="w-48 px-3 py-2 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm">
        <select name="fasilitas[${index}][tipe_fasilitas]"
            class="w-36 px-3 py-2.5 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm">
            <option value="konsumsi" ${tipe === 'konsumsi' ? 'selected' : ''}>🍽 Konsumsi</option>
            <option value="akomodasi" ${tipe === 'akomodasi' ? 'selected' : ''}>🏨 Akomodasi</option>
            <option value="transportasi" ${tipe === 'transportasi' ? 'selected' : ''}>🚌 Transportasi</option>
        </select>
        <button type="button" onclick="removeRow(this, 'fasilitas-container', 'fasilitas-empty', 'Belum ada fasilitas. Klik &quot;+ Tambah Fasilitas&quot; untuk menambahkan.')"
            class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>`;
            container.appendChild(div);
        }

        function addRundownField(waktu = '', acara = '', deskripsi = '') {
            const container = document.getElementById('rundowns-container');
            const empty = document.getElementById('rundowns-empty');
            if (empty) empty.remove();

            const index = container.querySelectorAll('.field-row').length;
            const div = document.createElement('div');
            div.className = 'field-row grid grid-cols-1 md:grid-cols-12 gap-4 items-start p-4 rounded-xl border border-admin-border bg-admin-bg/50';
            div.innerHTML = `
                <input type="hidden" name="rundowns[${index}][id]" value="">
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-admin-muted mb-1">Waktu / Hari</label>
                    <input type="text" name="rundowns[${index}][waktu]" value="${waktu}"
                        class="w-full px-3 py-2 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-sm"
                        placeholder="Contoh: Hari 1 / 08.00">
                </div>
                <div class="md:col-span-4">
                    <label class="block text-xs font-medium text-admin-muted mb-1">Acara / Kegiatan</label>
                    <input type="text" name="rundowns[${index}][acara]" value="${acara}"
                        class="w-full px-3 py-2 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-sm"
                        placeholder="Contoh: Kedatangan di Bandara">
                </div>
                <div class="md:col-span-4">
                    <label class="block text-xs font-medium text-admin-muted mb-1">Deskripsi</label>
                    <input type="text" name="rundowns[${index}][deskripsi]" value="${deskripsi}"
                        class="w-full px-3 py-2 rounded-lg border border-admin-border bg-admin-card text-admin-text focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-sm"
                        placeholder="Contoh: Penjemputan di gate kedatangan...">
                </div>
                <div class="md:col-span-1 flex items-end">
                    <button type="button" onclick="removeRundownRow(this)"
                        class="w-full p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>`;
            container.appendChild(div);
        }

        function removeRundownRow(btn) {
            const container = document.getElementById('rundowns-container');
            btn.closest('.field-row').remove();
            if (container.querySelectorAll('.field-row').length === 0) {
                const p = document.createElement('p');
                p.id = 'rundowns-empty';
                p.className = 'text-sm text-admin-muted italic';
                p.innerHTML = 'Belum ada rundown. Klik &quot;+ Tambah Rundown&quot; untuk menambahkan.';
                container.appendChild(p);
            }
        }

        function removeRow(btn, containerId, emptyId, emptyText) {
            const container = document.getElementById(containerId);
            btn.closest('.field-row').remove();
            renumberRows(containerId);
            if (container.querySelectorAll('.field-row').length === 0) {
                const p = document.createElement('p');
                p.id = emptyId;
                p.className = 'text-sm text-admin-muted italic';
                p.innerHTML = emptyText;
                container.appendChild(p);
            }
        }

        function renumberRows(containerId) {
            const rows = document.querySelectorAll(`#${containerId} .field-row`);
            rows.forEach((row, i) => {
                // Re-index all name attributes
                row.querySelectorAll('[name]').forEach(el => {
                    el.name = el.name.replace(/\[\d+\]/, `[${i}]`);
                });
                // Re-number badge (tempats only)
                const badge = row.querySelector('.rounded-full');
                if (badge) badge.textContent = i + 1;
            });
        }
    </script>
@endpush
