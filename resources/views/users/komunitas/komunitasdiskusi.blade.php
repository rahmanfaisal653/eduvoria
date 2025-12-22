@extends('layouts.app')

@section('title', $community->name . ' — Komunitas')

@section('content')
<div class="space-y-6">

  {{-- pesan sukses --}}
  @if(session('success'))
    <div class="mb-2 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- HEADER KOMUNITAS --}}
  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- background komunitas --}}
    @if($community->background_image)
      <div class="h-40 bg-cover bg-center"
           style="background-image: url('{{ asset('storage/komunitas/'.$community->background_image) }}')">
      </div>
    @else
      <div class="h-40 bg-gradient-to-r from-sky-500 to-emerald-500"></div>
    @endif

    <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

      {{-- foto + nama komunitas --}}
      <div class="flex items-center gap-4">
        @if($community->profile_image)
          <img src="{{ asset('storage/komunitas/'.$community->profile_image) }}"
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

      {{-- statistik --}}
      <div class="text-right space-y-2">
        <p class="text-xs text-slate-500">
          {{ number_format($community->members_count) }} Anggota
        </p>

        {{-- ======== TOMBOL GABUNG / KELUAR / PEMILIK ======== --}}
        @auth
            @if($isOwner ?? false)
                <button
                  type="button"
                  class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-gray-300 text-gray-700 text-sm font-semibold cursor-default">
                  Kamu Pemilik
                </button>
            @elseif($isMember ?? false)
                <form action="{{ route('community.leave', $community->id) }}" method="POST">
                  @csrf
                  <button
                    class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                    Keluar Grup
                  </button>
                </form>
            @else
                <form action="{{ route('community.join', $community->id) }}" method="POST">
                  @csrf
                  <button
                    class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                    Gabung Grup
                  </button>
                </form>
            @endif
        @endauth

        @guest
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold">
              Login untuk Gabung
            </a>
        @endguest

      </div>

    </div>
  </div>

  {{-- =========================
       KONTEN BAWAH
     ========================= --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    {{-- ======================================
         KIRI: FORM + DAFTAR POSTINGAN
       ====================================== --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- form posting --}}
      @auth
      @if(($isMember ?? false) || ($isOwner ?? false))
      <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-5 space-y-4">
        <h2 class="text-sm font-semibold text-emerald-800 mb-1">
          Mulai diskusi baru di grup ini:
        </h2>

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
            class="w-full rounded-2xl border border-emerald-100 px-4 py-3 text-sm"
            placeholder="Apa yang ingin Anda bagikan hari ini?">{{ old('content') }}</textarea>

          <div class="flex items-center justify-between text-xs">
            <label class="inline-flex items-center gap-1 cursor-pointer text-emerald-700">
              📷 Tambah Foto
              <input type="file" name="image" class="hidden">
            </label>

            <button class="px-5 py-2 rounded-full bg-emerald-600 text-white text-sm font-semibold">
              Kirim Postingan
            </button>
          </div>
        </form>
      </div>
      @elseif(!($isOwner ?? false))
      <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-2xl text-sm">
        Kamu harus bergabung untuk membuat postingan di komunitas ini.
      </div>
      @endif
      @endauth

      {{-- daftar postingan --}}
      @forelse ($posts as $post)
        <article class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">

          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-semibold text-slate-900">{{ $post->author_name ?? 'User' }}</p>
              <p class="text-xs text-slate-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>

            {{-- TOMBOL EDIT / HAPUS HANYA UNTUK PEMBUAT POSTINGAN (atau admin/owner) --}}
            @auth
                @php
                    $currentUser = auth()->user();
                $isStillMember = ($isMember ?? false) || ($isOwner ?? false);
                $canEditPost = ($bolehKelola ?? false)
                         || ($isStillMember && ($currentUser->name === ($post->author_name ?? '')));
                @endphp

                @if($canEditPost)
                    <div class="flex items-center gap-2 text-xs">
                      <a href="{{ route('community-posts.edit', [$community->id, $post->id]) }}"
                         class="px-2 py-1 border border-slate-300 rounded hover:bg-slate-50">
                         Edit
                      </a>

                      <form action="{{ route('community-posts.destroy', [$community->id, $post->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                          Hapus
                        </button>
                      </form>
                    </div>
                @endif
            @endauth

            {{-- {{-- @endauth (versi lama yang kelebihan, disimpan sebagai komentar) --}}

          </div>

          <p class="text-sm text-slate-700">{{ $post->content }}</p>

          @if($post->image)
            <img src="{{ asset('storage/postingan_komunitas/'.$post->image) }}"
                 class="rounded-2xl max-h-80 w-full object-cover">
          @endif

        </article>
      @empty
        <div class="bg-white rounded-3xl border border-slate-200 p-5 text-sm text-slate-500">
          Belum ada postingan.
        </div>
      @endforelse

    </div>

    {{-- ======================================
         KANAN: ADMIN, ANGGOTA, EVENT
       ====================================== --}}
    <div class="space-y-6">

      {{-- ADMIN / PEMBUAT KOMUNITAS --}}
      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">
          <h2 class="text-sm font-semibold text-slate-800">Admin Komunitas</h2>

          <div class="flex items-center gap-3 mt-2">
              
              {{-- Foto Profil Owner --}}
              @if($owner && $owner->profile_picture)
                  <img src="{{ asset('storage/'.$owner->profile_picture) }}"
                       class="h-10 w-10 rounded-full object-cover">
              @else
                  <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                      {{ strtoupper(substr($owner->name ?? 'A', 0, 1)) }}
                  </div>
              @endif

              {{-- Nama + role --}}
              <div>
                  <p class="text-sm font-semibold text-slate-900">
                      {{ $owner->name }}
                  </p>
                  <p class="text-xs text-emerald-600 font-medium">
                      Pembuat Komunitas
                  </p>
              </div>

          </div>
      </div>

      {{-- event --}}
      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 space-y-3">

        <div class="flex items-center justify-between gap-3">
          <h2 class="text-sm font-semibold text-slate-800">Kalender Acara</h2>

          {{-- link cepat ke kalender user --}}
          @auth
            <a href="{{ route('kalender.index') }}"
               class="text-[11px] font-semibold text-emerald-700 hover:underline">
              Lihat Kalender Saya
            </a>
          @endauth
        </div>

        @auth
        @if($bolehKelola ?? false)
        <form action="{{ route('community-events.store', $community->id) }}" method="POST" class="space-y-2 text-xs">
          @csrf

          <input name="title" class="w-full border px-3 py-2 rounded-2xl" placeholder="Judul acara">
          <textarea name="description" class="w-full border px-3 py-2 rounded-2xl" rows="2" placeholder="Deskripsi (opsional)"></textarea>

          <div class="grid grid-cols-2 gap-2">
            <input type="date" name="event_date" class="border px-3 py-2 rounded-2xl">
            <input type="time" name="start_time" class="border px-3 py-2 rounded-2xl">
          </div>

          <input type="time" name="end_time" class="border px-3 py-2 rounded-2xl">
          <input name="location" class="border px-3 py-2 rounded-2xl" placeholder="Lokasi">

          <button class="w-full bg-emerald-600 text-white py-2 rounded-full">+ Tambah Acara</button>
        </form>
        @endif
        @endauth

        @forelse($events as $event)
          <div class="border border-slate-200 rounded-2xl p-3 text-sm">
            <p class="font-medium">{{ $event->title }}</p>
            <p class="text-xs text-slate-500">
              {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
              @if($event->start_time) • {{ substr($event->start_time,0,5) }} WIB @endif
              @if($event->end_time) – {{ substr($event->end_time,0,5) }} WIB @endif
            </p>

            {{-- ===========================
                 DITAMBAH: OPT-IN KALENDER
                 - User NON-owner TIDAK otomatis masuk kalender
                 - Harus klik tombol "Tambah ke Kalender Saya"
               =========================== --}}
            @auth
              @php
                // cek apakah event ini sudah ditambahkan user ke kalender pribadinya
                $sudahDiKalenderSaya = \Illuminate\Support\Facades\DB::table('community_event_user')
                    ->where('community_event_id', $event->id)
                    ->where('user_id', auth()->id())
                    ->exists();

                $bolehTambahKeKalender = (($isMember ?? false) || ($isOwner ?? false));
              @endphp

              @if($bolehTambahKeKalender)
                <div class="flex items-center justify-between gap-2 mt-2">
                  <div class="text-[11px]">
                    @if($sudahDiKalenderSaya)
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold">
                        Sudah di Kalender
                      </span>
                    @else
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-50 text-slate-600 border border-slate-200 font-semibold">
                        Belum di Kalender
                      </span>
                    @endif
                  </div>

                  <div class="flex items-center gap-2 text-[11px]">
                    @if(!$sudahDiKalenderSaya)
                      <form method="POST" action="{{ route('community-events.addToCalendar', [$community->id, $event->id]) }}">
                        @csrf
                        <button type="submit"
                                class="px-2 py-1 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                          + Tambah ke Kalender Saya
                        </button>
                      </form>
                    @else
                      <form method="POST" action="{{ route('community-events.removeFromCalendar', [$community->id, $event->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-2 py-1 rounded-full bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300">
                          Hapus dari Kalender Saya
                        </button>
                      </form>
                    @endif
                  </div>
                </div>
              @endif
            @endauth

            @guest
              <div class="mt-2">
                <a href="{{ route('login') }}"
                   class="text-[11px] font-semibold text-emerald-700 hover:underline">
                  Login untuk menambahkan ke kalender
                </a>
              </div>
            @endguest

            @auth
            @if($bolehKelola ?? false)
            <div class="flex gap-2 mt-2 text-xs">
              <a class="px-2 py-1 border rounded" href="{{ route('community-events.edit', [$community->id, $event->id]) }}">Edit</a>

              <form method="POST" action="{{ route('community-events.destroy', [$community->id, $event->id]) }}">
                @csrf
                @method('DELETE')
                <button class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
              </form>
            </div>
            @endif
            @endauth
          </div>
        @empty
          <p class="text-xs text-slate-500">Belum ada acara.</p>
        @endforelse

      </div>

    </div>    
  </div>

</div>
@endsection
