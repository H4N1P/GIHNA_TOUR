@extends('components.layout.admin')
@section('title', 'Edit Pesanan Custom')
@section('header', 'Edit Pesanan Custom')

@section('content')
    {{-- $id = Pesanan model (sesuai variable yang dipass dari controller) --}}
    <form action="{{ route('admin.pesanan.update', $id->id) }}" method="POST" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        {{-- Data Pemesan --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center gap-3">
                <a href="{{ route('admin.pesanan.index') }}"
                    class="p-2 rounded-lg text-admin-muted hover:text-admin-text hover:bg-admin-bg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h3 class="text-lg font-semibold">Edit Pesanan Custom</h3>
                    <p class="text-sm text-admin-muted font-mono">{{ $id->invoice }}</p>
                </div>
            </div>
            <div class="p-4 lg:p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        Nama Perwakilan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan', $id->nama_pemesan) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('nama_pemesan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        No. HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $id->no_hp) }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        Tanggal Acara <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_acara"
                        value="{{ old('tanggal_acara', \Carbon\Carbon::parse($id->tanggal_acara)->format('Y-m-d')) }}"
                        required
                        class="admin-date-input w-full px-4 py-2.5 rounded-lg border border-admin-border bg-admin-card focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('tanggal_acara')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        Pax <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah_orang" id="jumlah_orang"
                        value="{{ old('jumlah_orang', $id->jumlah_orang) }}" required min="1"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('jumlah_orang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Custom Places --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border">
                <h3 class="text-lg font-semibold text-amber-600">Tempat Tujuan Custom</h3>
            </div>
            <div class="p-4 lg:p-6">
                <div id="places-container">
                    @if($id->custom_places)
                        @foreach($id->custom_places as $index => $place)
                            <div class="place-item flex gap-2 mb-2">
                                <input type="text" name="custom_places[]" value="{{ $place }}" required
                                    class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors"
                                    placeholder="Nama tempat tujuan">
                                <button type="button" onclick="removePlace(this)"
                                    class="px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addPlace()"
                    class="mt-3 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                    + Tambah Tempat
                </button>
                @error('custom_places')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Custom Fasilitas --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">Fasilitas Custom</h3>
                    <p class="text-sm text-admin-muted mt-0.5">Konsumsi, akomodasi, dan transportasi</p>
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
                    @if($id->custom_fasilitas)
                        @foreach($id->custom_fasilitas as $index => $fasilitas)
                            <div class="field-row flex gap-3 items-center">
                                <input type="text" name="custom_fasilitas[{{ $index }}][nama_fasilitas]" value="{{ $fasilitas['nama_fasilitas'] ?? '' }}"
                                    class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                    placeholder="Nama fasilitas (contoh: Hotel Bintang 5)">
                                <select name="custom_fasilitas[{{ $index }}][tipe_fasilitas]"
                                    class="w-44 px-3 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm">
                                    <option value="konsumsi" {{ ($fasilitas['tipe_fasilitas'] ?? '') === 'konsumsi' ? 'selected' : '' }}>🍽 Konsumsi</option>
                                    <option value="akomodasi" {{ ($fasilitas['tipe_fasilitas'] ?? '') === 'akomodasi' ? 'selected' : '' }}>🏨 Akomodasi</option>
                                    <option value="transportasi" {{ ($fasilitas['tipe_fasilitas'] ?? '') === 'transportasi' ? 'selected' : '' }}>🚌 Transportasi</option>
                                </select>
                                <button type="button" onclick="removeFasilitasRow(this)"
                                    class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <p id="fasilitas-empty" class="text-sm text-admin-muted italic">Belum ada fasilitas. Klik "+ Tambah Fasilitas" untuk menambahkan.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Harga & Status --}}
        <div class="bg-admin-card rounded-xl border border-admin-border">
            <div class="p-4 lg:p-6 border-b border-admin-border">
                <h3 class="text-lg font-semibold">Harga & Status</h3>
            </div>
            <div class="p-4 lg:p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        Diskon (%)
                    </label>
                    <input type="number" name="diskon" id="diskon" value="{{ old('diskon', $id->diskon ?? 0) }}" min="0"
                        max="100"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('diskon')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-text mb-2">
                        Total Harga <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="total_harga" id="total_harga" value="{{ old('total_harga', $id->total_harga) }}" required
                        min="0"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                    @error('total_harga')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-admin-text mb-2">Status Pesanan</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors">
                        <option value="pending" {{ old('status', $id->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="selesai" {{ old('status', $id->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status', $id->status) === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pesanan.index') }}"
                class="px-5 py-2.5 text-sm font-medium text-admin-text hover:bg-admin-bg rounded-lg transition-colors">Batal</a>
            <button type="submit"
                class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <script>
        function addPlace() {
            const container = document.getElementById('places-container');
            const div = document.createElement('div');
            div.className = 'place-item flex gap-2 mb-2';
            div.innerHTML = `
                <input type="text" name="custom_places[]" required
                    class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 focus:ring-2 focus:ring-amber-500 transition-colors"
                    placeholder="Nama tempat tujuan">
                <button type="button" onclick="removePlace(this)"
                    class="px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function removePlace(button) {
            const container = document.getElementById('places-container');
            if (container.children.length > 1) {
                button.closest('.place-item').remove();
            }
        }

        function addFasilitasField(nama = '', tipe = 'konsumsi') {
            const container = document.getElementById('fasilitas-container');
            const empty = document.getElementById('fasilitas-empty');
            if (empty) empty.remove();

            const index = container.querySelectorAll('.field-row').length;
            const div = document.createElement('div');
            div.className = 'field-row flex gap-3 items-center';
            div.innerHTML = `
                <input type="text" name="custom_fasilitas[${index}][nama_fasilitas]" value="${nama}"
                    class="flex-1 px-4 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                    placeholder="Nama fasilitas (contoh: Hotel Bintang 5)">
                <select name="custom_fasilitas[${index}][tipe_fasilitas]"
                    class="w-44 px-3 py-2.5 rounded-lg border border-admin-border bg-white dark:bg-neutral-800 text-admin-text focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors text-sm">
                    <option value="konsumsi" ${tipe === 'konsumsi' ? 'selected' : ''}>🍽 Konsumsi</option>
                    <option value="akomodasi" ${tipe === 'akomodasi' ? 'selected' : ''}>🏨 Akomodasi</option>
                    <option value="transportasi" ${tipe === 'transportasi' ? 'selected' : ''}>🚌 Transportasi</option>
                </select>
                <button type="button" onclick="removeFasilitasRow(this)"
                    class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>`;
            container.appendChild(div);
        }

        function removeFasilitasRow(button) {
            const container = document.getElementById('fasilitas-container');
            button.closest('.field-row').remove();
            if (container.querySelectorAll('.field-row').length === 0) {
                container.innerHTML = '<p id="fasilitas-empty" class="text-sm text-admin-muted italic">Belum ada fasilitas. Klik "+ Tambah Fasilitas" untuk menambahkan.</p>';
            }
        }
    </script>
@endsection