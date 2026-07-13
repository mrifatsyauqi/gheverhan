# PROJECT STATUS
*Dokumen ini merupakan ringkasan kondisi proyek (Real-time). Diperbarui setiap pergantian Sprint.*

## Status Utama
- **Versi Saat Ini:** v0.1 (In Progress)
- **Sprint Aktif:** Sprint 1.2 (Address Management)

## Riwayat Sprint
- **Sprint Selesai:** Sprint 1.0, 1.1A, 1.1B, 1.1C (Avatar Management)
- **Sprint Berikutnya:** Sprint 1.3 (Wishlist)

## Fitur & Modul
- **Selesai:** Auth Dasar, Display Produk, Cart Dasar, Edit Profile Dasar, Ganti Password, Upload Avatar.
- **Tertunda / Akan Dikerjakan:** Address, Wishlist, Checkout Flow Penuh, dll.

## Isu Terbuka (Bugs)
- **Terbuka:** 0 Bug.
- **Diselesaikan di Phase Q:**
  - BUG-001 (Critical): Relasi `cascadeOnDelete` di Order Items (Telah diperbaiki ke `nullOnDelete`).
  - BUG-002 (Medium): Script API (Axios) tertanam di UI/Blade (Telah direfaktor ke eksternal JS Vite).
  - BUG-003 (Low): Hardcoded warna `bg-gray-900` (Telah diganti dengan tema).

---

## Roadmap Pengembangan (Makro)
Berdasarkan visi untuk menjadikannya platform CMS / SaaS E-Commerce yang profesional (seperti WordPress), urutan fase besarnya adalah:
1. **Phase 1 (Business Ready):** Menyelesaikan seluruh alur inti e-commerce (Etalase, Cart, Checkout, Profil, dan Admin Dashboard Dasar).
2. **Phase Q (Testing & Stabilization):** Uji coba menyeluruh, optimasi performa, dan perbaikan *bug*.
3. **Phase I (Installation & Setup Wizard):** Fitur instalasi otomatis untuk pembeli/pengguna baru (cek server, setup *database*, form admin, & konfigurasi toko) dengan pengunci `install.lock`.
4. **Phase 2+ (Advanced Features):** Seller Center (Multi-tenant), Theme Builder, dan pengembangan lanjutan lainnya.

---
*Terakhir diperbarui: Menyepakati penambahan "Phase I: Installation Wizard" ke dalam Roadmap makro.*
