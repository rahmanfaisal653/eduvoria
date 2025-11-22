@extends('layouts.app')

@section('title', 'Pusat Komunitas — Eduvoria')

@section('content')
  <div class="mb-6">
    <h1 class="text-3xl font-extrabold tracking-tight">Pusat Komunitas</h1>
  </div>

  {{-- flash message sederhana --}}
  @if(session('success'))
    <div class="mb-4 bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg text-sm">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- =======================
        KIRI: DAFTAR KOMUNITAS
        ======================= --}}
    <section class="lg:col-span-2 space-y-6">

      <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 flex items-center justify-between">
          <h2 class="text-lg font-semibold">Komunitas</h2>
          <a href="{{ route('komunitas.index') }}" class="text-emerald-700 text-sm font-semibold">
            Lihat Semua
          </a>
        </div>

        <div class="divide-y divide-slate-200">
          @forelse ($communities as $community)
            <article class="p-6 space-y-3">

              {{-- BACKGROUND KOMUNITAS --}}
              @if($community->background_image)
                <div class="h-32 rounded-2xl bg-cover bg-center"
                     style="background-image: url('{{ asset('uploads/komunitas/'.$community->background_image) }}')">
                </div>
              @endif

              {{-- PROFIL + NAMA --}}
              <div class="flex items-center gap-4">
                @if($community->profile_image)
                  <img src="{{ asset('uploads/komunitas/'.$community->profile_image) }}"
                       class="h-14 w-14 rounded-full object-cover">
                @else
                  <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-xl text-slate-500">
                    {{ strtoupper(substr($community->name, 0, 1)) }}
                  </div>
                @endif

                <div>
                  <a href="{{ route('komunitas.show', $community->id) }}">
                    <h3 class="text-lg font-semibold text-slate-900">
                      {{ $community->name }}
                    </h3>
                  </a>
                  <p class="text-xs text-slate-500">
                    {{ $community->category ? '#'.$community->category : '' }}
                  </p>
                </div>
              </div>

              {{-- DESKRIPSI --}}
              <p class="text-sm text-slate-600">
                {{ $community->description }}
              </p>

              {{-- INFO & AKSI --}}
              <div class="mt-2 flex items-center justify-between text-xs">

                <div class="flex items-center gap-4 text-slate-500">
                  <span>👥 {{ $community->members_count }} Anggota</span>
                  <span>ID Owner: {{ $community->owner_id }}</span>
                </div>

                <div class="flex items-center gap-2">
                  {{-- tombol EDIT --}}
                  <a href="{{ route('komunitas.edit', $community->id) }}"
                     class="px-3 py-1 rounded-lg border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                    Edit
                  </a>

                  {{-- tombol HAPUS --}}
                  <form action="{{ route('komunitas.destroy', $community->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus komunitas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700">
                      Hapus
                    </button>
                  </form>
                </div>

              </div>

            </article>
          @empty
            <div class="p-6 text-sm text-slate-500">
              Belum ada komunitas yang dibuat.
            </div>
          @endforelse
        </div>
      </div>

    </section>

    {{-- =======================
        KANAN: SIDEBAR
        ======================= --}}
    <aside class="lg:col-span-1 space-y-6">

      {{-- KARTU BUAT KOMUNITAS BARU --}}
      <div class="bg-emerald-700 text-white rounded-2xl shadow-sm">
        <div class="p-6 space-y-3">
          <h2 class="text-xl font-bold">Mulai Komunitas Baru</h2>
          <p class="text-sm opacity-90">
            Ingin membuat ruang komunitas sendiri? Buat komunitas Anda sendiri.
          </p>

          <a href="{{ route('komunitas.create') }}"
             class="block text-center mt-2 bg-white text-emerald-700 font-semibold px-4 py-2 rounded-xl hover:bg-slate-50">
            + Buat Komunitas
          </a>
        </div>
      </div>

      {{-- kalau nanti mau pakai acara / grup, bisa tambahkan di sini --}}
    </aside>

  </div>
@endsection
