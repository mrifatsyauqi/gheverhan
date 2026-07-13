@extends('admin.layouts.app')
@section('title', 'Pengaturan Toko')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Pengaturan Toko</h1>
    <p class="text-sm text-gray-500">Konfigurasi umum, tampilan, dan informasi toko.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Tabs Nav (For large screens this acts as a sidebar, on small it stacks) -->
        <div class="lg:col-span-1" x-data="{ tab: 'general' }">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 sticky top-24">
                <button type="button" @click="tab = 'general'" :class="tab == 'general' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium mb-1 transition">
                    Umum & Kontak
                </button>
                <button type="button" @click="tab = 'appearance'" :class="tab == 'appearance' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium mb-1 transition">
                    Logo & Tampilan
                </button>
                <button type="button" @click="tab = 'social'" :class="tab == 'social' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium mb-1 transition">
                    Sosial Media
                </button>
                <button type="button" @click="tab = 'seo'" :class="tab == 'seo' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50'" class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium transition">
                    SEO & Meta
                </button>
                
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-black text-white font-bold py-2.5 rounded-lg hover:bg-gray-800 transition shadow">
                        Simpan Semua Pengaturan
                    </button>
                </div>
            </div>

            <!-- Content Area - using absolute positioning logic via Alpine for simplicity in single form -->
            <!-- General Tab -->
            <div x-show="tab == 'general'" class="fixed inset-0 z-0 opacity-0 pointer-events-none lg:static lg:opacity-100 lg:pointer-events-auto mt-6 lg:mt-0 lg:col-span-3 lg:block" style="grid-column: 2 / span 3;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Pengaturan Umum & Kontak</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                            <input type="text" name="settings[store_name]" value="{{ $settings['store_name'] ?? 'GHEVERHAN' }}" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat (Tampil di footer)</label>
                            <textarea name="settings[store_description]" rows="3" class="w-full border-gray-300 rounded-md">{{ $settings['store_description'] ?? '' }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Toko</label>
                                <input type="email" name="settings[contact_email]" value="{{ $settings['contact_email'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon (CS)</label>
                                <input type="text" name="settings[contact_phone]" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (Admin)</label>
                            <input type="text" name="settings[contact_whatsapp]" value="{{ $settings['contact_whatsapp'] ?? '' }}" placeholder="Contoh: 6281234567890" class="w-full border-gray-300 rounded-md">
                            <p class="text-xs text-gray-500 mt-1">Gunakan awalan 62 tanpa spasi atau karakter +.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Toko</label>
                            <textarea name="settings[address]" rows="3" class="w-full border-gray-300 rounded-md">{{ $settings['address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appearance Tab -->
            <div x-show="tab == 'appearance'" class="fixed inset-0 z-0 opacity-0 pointer-events-none lg:static lg:opacity-100 lg:pointer-events-auto mt-6 lg:mt-0 lg:col-span-3 lg:hidden" style="grid-column: 2 / span 3;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Logo & Tampilan</h2>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL Logo Toko</label>
                            <input type="text" name="settings[store_logo]" value="{{ $settings['store_logo'] ?? '' }}" placeholder="https://..." class="w-full border-gray-300 rounded-md mb-2">
                            @if(isset($settings['store_logo']) && $settings['store_logo'])
                                <div class="p-4 bg-gray-100 rounded-lg inline-block"><img src="{{ $settings['store_logo'] }}" class="h-10 object-contain"></div>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL Favicon</label>
                            <input type="text" name="settings[store_favicon]" value="{{ $settings['store_favicon'] ?? '' }}" placeholder="https://..." class="w-full border-gray-300 rounded-md">
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Pengumuman (Announcement Bar)</h3>
                            <label class="flex items-center gap-2 cursor-pointer mb-3">
                                <input type="hidden" name="settings[announcement_bar_active]" value="0">
                                <input type="checkbox" name="settings[announcement_bar_active]" value="1" {{ ($settings['announcement_bar_active'] ?? '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-primary">
                                <span class="text-sm font-medium text-gray-700">Tampilkan Bar Pengumuman di Atas Website</span>
                            </label>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Pengumuman</label>
                                <input type="text" name="settings[announcement_bar_text]" value="{{ $settings['announcement_bar_text'] ?? 'Gratis Ongkir ke Seluruh Indonesia!' }}" class="w-full border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Tab -->
            <div x-show="tab == 'social'" class="fixed inset-0 z-0 opacity-0 pointer-events-none lg:static lg:opacity-100 lg:pointer-events-auto mt-6 lg:mt-0 lg:col-span-3 lg:hidden" style="grid-column: 2 / span 3;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Sosial Media</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                            <input type="url" name="settings[instagram_url]" value="{{ $settings['instagram_url'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                            <input type="url" name="settings[facebook_url]" value="{{ $settings['facebook_url'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">TikTok URL</label>
                            <input type="url" name="settings[tiktok_url]" value="{{ $settings['tiktok_url'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Tab -->
            <div x-show="tab == 'seo'" class="fixed inset-0 z-0 opacity-0 pointer-events-none lg:static lg:opacity-100 lg:pointer-events-auto mt-6 lg:mt-0 lg:col-span-3 lg:hidden" style="grid-column: 2 / span 3;">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">SEO & Meta Tags</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title (Homepage)</label>
                            <input type="text" name="settings[meta_title]" value="{{ $settings['meta_title'] ?? '' }}" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="settings[meta_description]" rows="4" class="w-full border-gray-300 rounded-md">{{ $settings['meta_description'] ?? '' }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Disarankan 150-160 karakter untuk optimasi pencarian Google.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
