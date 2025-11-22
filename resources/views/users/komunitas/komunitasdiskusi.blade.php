@extends('layouts.app')

@section('title', $community->name . ' — Komunitas')

@section('content')
<div class="space-y-6">

  {{-- Pesan sukses umum (misal setelah tambah / edit / hapus postingan) --}}
  @if(session('success'))
    <div class="mb-2 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- =========================
       HEADER KOMUNITAS
     ========================= --}}
  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- Background komunitas: pakai foto kalau ada, kalau tidak gradient --}}
    @if($community->background_image)
      <div class="h-40 bg-cover bg-center"
           style="background-image: url('{{ asset('uploads/komunitas/'.$community->background_image) }}')">
      </div>
    @else
      <div class="h-40 bg-gradient-to-r from-sky-500 to-emerald-500"></div>
    @endif

    <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

      {{-- Kiri: foto profil + nama komunitas --}}
      <div class="flex items-center gap-4">
        @if($community->profile_image)
          <img src="{{ asset('uploads/komunitas/'.$community->profile_image) }}"
               class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-white object-cover -mt-12 sm:-mt-16">
        @else
          <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-full border-4 border-white bg-slate-100 flex items-center justify-center text-2xl text-slate-500 -mt-12 sm:-mt-16">
            {{ strtoupper(substr($community->name,0,1)) }}
          </div>
        @endif

        <div class="mt-2 sm:mt-0">
          <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
            {{ $community->name }}
          </h1>

          <p class="text-xs sm:text-sm text-emerald-100 bg-emerald-600 inline-block px-3 py-1 rounded-full mt-1">
            Grup Aktif • Sejak {{ $community->created_at->format('Y') }}
          </p>

          <p class="mt-2 text-sm text-slate-600">
            {{ $community->description ?: 'Belum ada deskripsi untuk komunitas ini.' }}
          </p>
        </div>
      </div>

      {{-- Kanan: statistik sederhana + tombol gabung --}}
      <div class="text-right space-y-2">
        <p class="text-xs text-slate-500">
          {{ number_format($community->members_count) }} Anggota • 120 Postingan/Minggu
        </p>

        <button
          type="button"
          class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
          Gabung Grup
        </button>
      </div>
    </div>
  </div>

  {{-- =========================
       KONTEN BAWAH
     ========================= --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ======================================
         KIRI: FORM POSTING + DAFTAR POSTING
       ====================================== --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- FORM: MULAI DISKUSI BARU --}}
      <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-5 space-y-4">
        <h2 class="text-sm font-semibold text-emerald-800 mb-1">
          Mulai diskusi baru di grup ini:
        </h2>

        {{-- error validasi sederhana --}}
        @if($errors->any())
          <div class="mb-2 bg-red-50 text-red-700 px-3 py-2 rounded text-xs">
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif

        <form action="{{ route('community-posts.store', $community->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-3">
          @csrf

          <textarea
            name="content"
            rows="3"
            class="w-full rounded-2xl border border-emerald-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400"
            placeholder="Apa yang ingin Anda bagikan hari ini? (Tips, Pertanyaan, Foto)">{{ old('content') }}</textarea>

          <div class="flex flex-wrap items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-4">
              <label class="inline-flex items-center gap-1 cursor-pointer">
                <span class="text-emerald-700 font-semibold">📷 Tambah Foto</span>
                <input type="file" name="image" class="hidden">
              </label>
            </div>

            <button type="submit"
                    class="px-5 py-2 rounded-full bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700">
              Kirim Postingan
            </button>
          </div>
        </form>
      </div>

      {{-- DAFTAR POSTINGAN KOMUNITAS --}}
      @forelse ($posts as $post)
        <article class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">

          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-semibold text-slate-900">{{ $post->author_name ?? 'User' }}</p>
              <p class="text-xs text-slate-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>

            {{-- tombol EDIT & HAPUS postingan --}}
            <div class="flex items-center gap-2 text-xs">
              <a href="{{ route('community-posts.edit', [$community->id, $post->id]) }}"
                 class="px-2 py-1 rounded border border-slate-300 hover:bg-slate-50">
                Edit
              </a>

              <form action="{{ route('community-posts.destroy', [$community->id, $post->id]) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                  Hapus
                </button>
              </form>
            </div>
          </div>

          <p class="text-sm text-slate-700">
            {{ $post->content }}
          </p>

          @if($post->image)
            <div class="mt-2">
              <img src="{{ asset('uploads/postingan_komunitas/'.$post->image) }}"
                   class="rounded-2xl max-h-80 object-cover w-full">
            </div>
          @endif

        </article>
      @empty
        <div class="bg-white rounded-3xl možnostshadow-sm border border-slate-200 p-5 text-sm text-slate-500">
          Belum ada postingan di komunitas ini.
        </div>
      @endforelse

    </div>

    {{-- ======================================
         KANAN: ADMIN, ANGGOTA, KALENDER
       ====================================== --}}
    <div class="space-y-6">

      {{-- ADMIN & MODERATOR (placeholder) --}}
      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">
        <h2 class="text-sm font-semibold text-slate-800">Admin & Moderator</h2>

        <div class="space-y-2 text-sm">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 rounded-full bg-pink-500"></span>
              <span>Dewi Lestari</span>
            </div>
            <span class="text-xs text-pink-500 font-semibold">(Admin)</span>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 rounded-full bg-blue-500"></span>
              <span>Budi Santoso</span>
            </div>
            <span class="text-xs text-blue-500 font-semibold">(Moderator)</span>
          </div>
        </div>

        <button type="button" class="mt-3 text-xs text-red-500">
          Laporkan Grup
        </button>
      </div>

      {{-- ANGGOTA TERBARU (placeholder) --}}
      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">
        <h2 class="text-sm font-semibold text-slate-800">Anggota Terbaru</h2>

        <div class="flex items-center gap-2">
          <span class="h-7 w-7 rounded-full bg-rose-400"></span>
          <span class="h-7 w-7 rounded-full bg-amber-400"></span>
          <span class="h-7 w-7 rounded-full bg-emerald-400"></span>
          <span class="h-7 w-7 rounded-full bg-sky-400"></span>
          <span class="h-7 w-7 rounded-full bg-violet-400"></span>
          <span class="text-xs text-slate-500">+12</span>
        </div>

        <button type="button"
                class="mt-3 w-full text-center text-xs font-semibold text-emerald-700 border border-emerald-600 rounded-full py-2 hover:bg-emerald-50">
          Lihat Semua Anggota
        </button>
      </div>

    {{-- KALENDER ACARA --}}
<div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-4">
  <h2 class="text-sm font-semibold text-slate-800">Kalender Acara</h2>

  {{-- FORM TAMBAH ACARA (disamakan dengan Edit Acara) --}}
  <form action="{{ route('community-events.store', $community->id) }}"
        method="POST"
        class="space-y-3 text-xs">
    @csrf

    {{-- Judul --}}
    <input
      type="text"
      name="title"
      value="{{ old('title') }}"
      class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
      placeholder="Judul acara"
      required>

    {{-- Deskripsi --}}
    <textarea
      name="description"
      rows="2"
      class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
      placeholder="Deskripsi singkat acara (opsional)">{{ old('description') }}</textarea>

    {{-- Tanggal & Jam mulai --}}
    <div class="grid grid-cols-2 gap-2">
      <input
        type="date"
        name="event_date"
        value="{{ old('event_date') }}"
        class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        required>

      <input
        type="time"
        name="start_time"
        value="{{ old('start_time') }}"
        class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        placeholder="Jam mulai">
    </div>

    {{-- Jam selesai --}}
    <input
      type="time"
      name="end_time"
      value="{{ old('end_time') }}"
      class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
      placeholder="Jam selesai (opsional)">

    {{-- Lokasi --}}
    <input
      type="text"
      name="location"
      value="{{ old('location') }}"
      class="w-full border border-slate-300 rounded-2xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
      placeholder="Lokasi (opsional)">

    <button type="submit"
            class="w-full mt-1 text-center text-xs font-semibold text-white bg-emerald-600 rounded-full py-2 hover:bg-emerald-700">
      + Tambah Acara
    </button>
  </form>

  {{-- DAFTAR ACARA KOMUNITAS INI --}}
  <div class="space-y-3 text-sm">
    @forelse($events as $event)
      <div class="border border-slate-200 rounded-2xl px-3 py-2">
        <div class="flex items-center justify-between gap-2">
          <div>
            <p class="font-medium text-slate-900">{{ $event->title }}</p>
            <p class="text-xs text-slate-500">
              {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
              @if($event->start_time)
                • {{ substr($event->start_time, 0, 5) }} WIB
              @endif
              @if($event->end_time)
                – {{ substr($event->end_time, 0, 5) }} WIB
              @endif
            </p>
            @if($event->location)
              <p class="text-xs text-slate-500 mt-1">📍 {{ $event->location }}</p>
            @endif
          </div>

          <div class="flex flex-col gap-1 text-[11px]">
            <a href="{{ route('community-events.edit', [$community->id, $event->id]) }}"
               class="px-2 py-0.5 rounded border border-slate-300 hover:bg-slate-50 text-slate-700 text-center">
              Edit
            </a>

            <form action="{{ route('community-events.destroy', [$community->id, $event->id]) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus acara ini?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="px-2 py-0.5 rounded bg-red-600 text-white hover:bg-red-700">
                Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="text-xs text-slate-500">
        Belum ada acara terjadwal untuk komunitas ini.
      </p>
    @endforelse
  </div>
</div>

    </div>
  </div>
</div>
@endsection
