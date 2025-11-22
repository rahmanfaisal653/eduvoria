@extends('layouts.app') {{-- sesuaikan dengan layout milikmu --}}

@section('title', 'Komunitas Diskusi')

@section('content')
<style>
    body {
        background: #f5f7fb;
    }

    .kom-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 24px 16px 40px;
    }

    .kom-hero-card {
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        overflow: hidden;
        background: #fff;
        margin-bottom: 24px;
    }

    .kom-hero-banner {
        background: linear-gradient(90deg, #1d75ff, #00b3a4);
        min-height: 190px;
        display: flex;
        align-items: center;
        padding: 24px 40px;
        color: #fff;
    }

    .kom-hero-banner h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
    }

    .kom-hero-body {
        padding: 24px 40px 28px;
        background: #fff;
    }

    .kom-hero-body-title {
        font-size: 20px;
        font-weight: 600;
    }

    .kom-card-soft {
        border-radius: 20px;
        border: none;
        background: #ffffff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, 0.08);
    }

    .kom-card-soft-outline {
        border-radius: 20px;
        border: 1px solid #c9f1e4;
        background: #f6fffb; /* hijau muda */
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    .kom-textarea {
        width: 100%;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 10px 12px;
        resize: vertical;
        font-size: 14px;
    }

    .kom-btn-primary {
        border-radius: 999px;
        padding: 8px 28px;
        font-weight: 600;
        background: #06b48b;
        border: 1px solid #06b48b;
        color: #fff;
        cursor: pointer;
    }

    .kom-btn-primary:hover {
        background: #04936f;
        border-color: #04936f;
    }

    .kom-avatar-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
    }

    .kom-post-meta span {
        margin-right: 18px;
    }

    /* FLEX LAYOUT TANPA BOOTSTRAP */

    .kom-row {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        margin-bottom: 24px;
    }

    .kom-main {
        flex: 1 1 100%;
    }

    .kom-side {
        flex: 1 1 100%;
    }

    @media (min-width: 992px) {
        .kom-main {
            flex: 0 0 66.666%;
            max-width: 66.666%;
        }

        .kom-side {
            flex: 0 0 31%;
            max-width: 31%;
        }
    }
</style>

<div class="kom-container">

    {{-- ========================= HERO / HEADER ========================= --}}
    <div class="kom-hero-card">
        <div class="kom-hero-banner">
            <h2><span class="me-2">📷</span>Fotografi Alam Nusantara</h2>
        </div>

        <div class="kom-hero-body">
            <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center;">
                <div style="flex:1 1 260px;">
                    <div style="color:#00a66a;" class="small fw-semibold mb-1">
                        Grup Aktif • Sejak 2020
                    </div>
                    <div class="kom-hero-body-title mb-1">
                        Room Diskusi Fotografi Alam
                    </div>
                    <p class="mb-0" style="color:#6b7280; font-size:14px;">
                        Tempat berkumpulnya para pecinta fotografi alam. Bagikan hasil jepretan terbaik,
                        diskusikan teknik, dan cari teman hunting baru.
                    </p>
                </div>

                <div style="flex:0 0 auto; text-align:right;">
                    <div style="margin-bottom:6px; color:#6b7280; font-weight:600; font-size:14px;">
                        2,140 Anggota &nbsp;&nbsp; 120 Postingan/Minggu
                    </div>
                    <button class="kom-btn-primary">
                        Gabung Grup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- =================== BARIS: FORM DISKUSI + ADMIN =================== --}}
    <div class="kom-row">
        {{-- Form diskusi (kiri) --}}
        <div class="kom-main">
            <div class="kom-card-soft-outline" style="padding:16px 20px 18px;">
                <h6 class="fw-semibold mb-3" style="font-size:14px;">
                    Mulai diskusi baru di grup ini:
                </h6>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <textarea
                            class="kom-textarea"
                            rows="3"
                            placeholder="Apa yang ingin Anda bagikan hari ini? (Tips, Pertanyaan, Foto)"
                        ></textarea>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div style="display:flex; align-items:center; gap:18px; font-size:13px;">
                            <label style="cursor:pointer; color:#16a34a; margin:0;">
                                <span style="margin-right:4px;">🖼</span> Tambah Foto
                                <input type="file" name="foto" style="display:none;">
                            </label>

                            <label style="cursor:pointer; color:#6b7280; margin:0;">
                                📎 Lampirkan File
                                <input type="file" name="lampiran" style="display:none;">
                            </label>
                        </div>

                        <button type="submit" class="kom-btn-primary">
                            Kirim Postingan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Admin & Moderator (kanan atas) --}}
        <div class="kom-side">
            <div class="kom-card-soft" style="padding:18px 20px;">
                <h6 class="fw-semibold mb-3" style="font-size:14px;">Admin &amp; Moderator</h6>

                <div style="display:flex; align-items:center; margin-bottom:10px;">
                    <div class="kom-avatar-dot" style="background:#ff4fa8; margin-right:8px;"></div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px;">Dewi Lestari</div>
                        <div style="font-size:12px;">
                            <span style="color:#9ca3af;">(</span>
                            <span style="color:#00a66a;">Admin</span>
                            <span style="color:#9ca3af;">)</span>
                        </div>
                    </div>
                </div>

                <div style="display:flex; align-items:center; margin-bottom:10px;">
                    <div class="kom-avatar-dot" style="background:#2563eb; margin-right:8px;"></div>
                    <div>
                        <div class="fw-semibold" style="font-size:13px;">Budi Santoso</div>
                        <div style="font-size:12px;">
                            <span style="color:#9ca3af;">(</span>
                            <span style="color:#3b82f6;">Moderator</span>
                            <span style="color:#9ca3af;">)</span>
                        </div>
                    </div>
                </div>

                <a href="#" style="font-size:12px; color:#ef4444; text-decoration:none;">
                    Laporkan Grup
                </a>
            </div>
        </div>
    </div>

    {{-- =================== BARIS: POSTING + SIDEBAR BAWAH =================== --}}
    <div class="kom-row">
        {{-- Postingan (kiri) --}}
        <div class="kom-main">

            {{-- Post 1 --}}
            <div class="kom-card-soft" style="padding:18px 20px; margin-bottom:24px;">
                <div style="display:flex; justify-content:space-between;">
                    <div>
                        <div class="fw-semibold" style="font-size:14px;">Rifky Pratama</div>
                        <div style="font-size:12px; color:#9ca3af;">2 jam yang lalu</div>
                    </div>
                    <div style="color:#9ca3af;">•••</div>
                </div>

                <p style="margin-top:14px; margin-bottom:10px; font-size:14px;">
                    Menikmati sore yang cerah dengan secangkir kopi favorit. Apa rencana kalian hari ini?
                </p>

                <div style="margin-bottom:10px;">
                    <img src="https://via.placeholder.com/640x320"
                         alt="Post Image"
                         style="width:100%; border-radius:16px;">
                </div>

                <div class="kom-post-meta" style="font-size:12px; color:#9ca3af;">
                    <span>❤️ 724 Suka</span>
                    <span>💬 19 Komentar</span>
                    <span>🔖 Bookmark</span>
                    <span>↗ Bagikan</span>
                </div>
            </div>

            {{-- Post 2 --}}
            <div class="kom-card-soft" style="padding:18px 20px;">
                <div style="display:flex; justify-content:space-between;">
                    <div>
                        <div class="fw-semibold" style="font-size:14px;">Dewi Lestari</div>
                        <div style="font-size:12px; color:#9ca3af;">5 jam yang lalu</div>
                    </div>
                    <div style="color:#9ca3af;">•••</div>
                </div>

                <p style="margin-top:14px; margin-bottom:0; font-size:14px;">
                    Baru saja menyelesaikan proyek yang cukup menantang, hasilnya sangat memuaskan.
                    Kerja keras selalu terbayar. #ProyekBaru #UIUX
                </p>

                <div class="kom-post-meta" style="font-size:12px; color:#9ca3af; margin-top:10px;">
                    <span>❤️ 452 Suka</span>
                    <span>💬 8 Komentar</span>
                    <span>🔖 Bookmark</span>
                    <span>↗ Bagikan</span>
                </div>
            </div>
        </div>

        {{-- Sidebar bawah (kanan) --}}
        <div class="kom-side">

            {{-- Anggota Terbaru --}}
            <div class="kom-card-soft" style="padding:18px 20px; margin-bottom:24px;">
                <h6 class="fw-semibold mb-3" style="font-size:14px;">Anggota Terbaru</h6>

                <div style="display:flex; align-items:center; margin-bottom:12px;">
                    <div style="display:flex;">
                        <div class="kom-avatar-dot" style="background:#fb7185; margin-right:4px;"></div>
                        <div class="kom-avatar-dot" style="background:#f97316; margin-right:4px;"></div>
                        <div class="kom-avatar-dot" style="background:#22c55e; margin-right:4px;"></div>
                        <div class="kom-avatar-dot" style="background:#3b82f6; margin-right:4px;"></div>
                        <div class="kom-avatar-dot" style="background:#a855f7; margin-right:4px;"></div>
                    </div>
                    <span style="font-size:12px; margin-left:6px; font-weight:600; color:#6366f1;">+12</span>
                </div>

                <button class="kom-btn-primary" style="width:100%; padding-block:6px; background:#fff; color:#16a34a; border-color:#16a34a;">
                    Lihat Semua Anggota
                </button>
            </div>

            {{-- Aturan Grup --}}
            <div class="kom-card-soft" style="padding:18px 20px;">
                <h6 class="fw-semibold mb-3" style="font-size:14px;">Aturan Grup</h6>
                <ol style="font-size:12px; padding-left:18px; margin:0; color:#6b7280;">
                    <li>Hormati karya anggota lain.</li>
                    <li>Postingan harus relevan dengan fotografi alam.</li>
                    <li>Dilarang keras spam atau promosi ilegal.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
