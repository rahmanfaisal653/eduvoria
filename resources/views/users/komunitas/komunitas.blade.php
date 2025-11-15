@extends('layouts.app')

@section('title', 'Pusat Komunitas — Eduvoria')


@section('content')
  <div class="mb-6">
    <h1 class="text-3xl font-extrabold tracking-tight">Pusat Komunitas</h1>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kiri: Diskusi Populer + Grup --}}
    <section class="lg:col-span-2 space-y-6">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 flex items-center justify-between">
          <h2 class="text-lg font-semibold">Diskusi Populer</h2>
          <a href="#" class="text-emerald-700 text-sm font-semibold">Lihat Semua</a>
        </div>
        <div class="divide-y divide-slate-200">
          @foreach ($popularDiscussions as $d)
            <article class="p-6">
              <a href="{{ $d['url'] }}" class="block">
                <h3 class="text-base sm:text-lg font-semibold text-slate-900">{{ $d['title'] }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ $d['excerpt'] }}</p>
              </a>
              <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                <span>#{{ $d['topic'] }}</span>
                <span>{!! $d['is_hot'] ? '🔥' : '💬' !!} {{ $d['comments'] }} Komentar</span>
                <span>Oleh: {{ $d['author'] }}</span>
              </div>
            </article>
          @endforeach
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 flex items-center justify-between">
          <h2 class="text-lg font-semibold">Grup yang Mungkin Anda Suka</h2>
          <a href="#" class="text-emerald-700 text-sm font-semibold">Jelajahi Grup</a>
        </div>
        <div class="px-6 pb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
          @foreach ($suggestedGroups as $g)
            <div class="rounded-2xl border border-slate-200 p-5 flex flex-col items-center text-center gap-3">
              <div class="h-16 w-16 rounded-full bg-slate-100 flex items-center justify-center text-2xl">{{ $g['icon'] }}</div>
              <div>
                <h3 class="font-semibold">{{ $g['name'] }}</h3>
                <p class="text-xs text-slate-500">{{ $g['members'] }} Anggota</p>
              </div>
              <a href="{{ $g['url'] }}"
                 class="mt-1 inline-block px-4 py-1.5 rounded-full border border-emerald-600 text-emerald-700 text-xs font-semibold hover:bg-emerald-50">
                 Gabung
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </section>
{{-- Kanan: Mulai Obrolan Baru + Acara Mendatang --}}
<aside class="lg:col-span-1 space-y-6">
  <div class="bg-emerald-700 text-white rounded-2xl shadow-sm">
    <div class="p-6 space-y-3">
      <h2 class="text-xl font-bold">Mulai Obrolan Baru</h2>
      <p class="text-sm opacity-90">Punya pertanyaan atau ingin berbagi ide? Buat diskusi Anda sendiri!</p>

      {{-- Link sederhana ke halaman form --}}
      <a href="{{ route('komunitas.create') }}"
         class="block text-center mt-2 bg-white text-emerald-700 font-semibold px-4 py-2 rounded-xl hover:bg-slate-50">
        + Buat Diskusi
      </a>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
    
    <div class="p-6">
      <h2 class="text-lg font-semibold">Acara Mendatang</h2>
      <div class="mt-4 space-y-4">
        @forelse ($upcomingEvents as $e)
          <a href="{{ $e['url'] }}" class="block rounded-xl border border-slate-200 p-4 hover:bg-slate-50">
            <p class="text-sm font-medium">{{ $e['title'] }}</p>
            <p class="text-xs text-slate-500">{{ $e['date'] }} | {{ $e['time'] }}</p>
          </a>
        @empty
          <p class="text-sm text-slate-500">Belum ada acara.</p>
        @endforelse
      </div>
      <a href="#" class="mt-5 block text-center w-full rounded-xl bg-emerald-600 text-white font-semibold py-2 hover:bg-emerald-700">
        Lihat Kalender Acara
      </a>
    </div>
  </div>
</aside>
  </div>
@endsection
