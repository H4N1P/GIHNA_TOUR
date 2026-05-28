<footer class="mt-20 w-full px-4 py-12 text-white sm:px-6 lg:px-14 lg:py-16">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="mb-4 flex items-center gap-3">
                <img src="{{ asset('customer/assets/images/logos/logo.png') }}" alt="Logo" class="h-10 w-auto max-w-full" />
                <div>
                    <div class="font-bold">Ghina Tour Travel</div>
                    <div class="text-[10px]" style="color:var(--gold);">Serving With Love</div>
                </div>
            </div>
            <p class="text-sm leading-6 text-gray-400">
                {{ $companyProfile->about ?? 'Biro perjalanan wisata terpercaya. Melayani perjalanan rombongan dengan harga sesuai anggaran Anda.' }}
            </p>
        </div>

        <div>
            <h4 class="mb-4 font-bold">Tautan</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">Beranda</a></li>
                <li><a href="{{ route('packages') }}" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">Paket Wisata</a>
                </li>
                <li><a href="{{ route('photos') }}" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">Galeri</a></li>
            </ul>
        </div>

        <div>
            <h4 class="mb-4 font-bold">Layanan</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li>Paket Wisata</li>
                <li>Transportasi</li>
                <li>Akomodasi</li>
                <li>Konsumsi</li>
            </ul>
        </div>

        {{-- Kontak --}}
        <div>
            <h4 class="mb-4 font-bold">Kontak</h4>
            <ul class="space-y-4 text-sm text-gray-400">
                @if ($companyProfile?->address)
                    <li class="flex items-start gap-3">
                        <img src="{{ asset('customer/icon/address.svg') }}" class="h-5 w-5 mt-0.5" alt="Address" />
                        <span>{{ $companyProfile->address }}</span>
                    </li>
                @endif

                @if ($companyProfile?->whatsapp)
                    <li class="flex items-center gap-3">
                        <img src="{{ asset('customer/icon/whatsapp.svg') }}" class="h-5 w-5" alt="WhatsApp" />
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $companyProfile->whatsapp) }}"
                            target="_blank" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">
                            {{ $companyProfile->whatsapp }}
                        </a>
                    </li>
                @endif

                @if ($companyProfile?->email)
                    <li class="flex items-center gap-3">
                        <img src="{{ asset('customer/icon/gmail.svg') }}" class="h-5 w-5" alt="Email" />
                        <a href="mailto:{{ $companyProfile->email }}" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">
                            {{ $companyProfile->email }}
                        </a>
                    </li>
                @endif

                @if ($companyProfile?->instagram)
                    <li class="flex items-center gap-3">
                        <img src="{{ asset('customer/icon/instagram.svg') }}" class="h-5 w-5" alt="Instagram" />
                        <a href="https://www.instagram.com/ghinatourandtravel/{{ ltrim($companyProfile->instagram, '@') }}"
                            target="_blank" class="inline-flex min-h-11 items-center hover:text-yellow-500 transition-colors">
                            {{ $companyProfile->instagram }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="mx-auto mt-12 max-w-7xl border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} PT Ghina Tour Travel. All rights reserved.</p>
    </div>
</footer>
