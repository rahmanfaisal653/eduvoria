@extends('layouts.app')

@section('title', 'Kalender Acara — Eduvoria')

@section('content')
<div class="max-w-5xl mx-auto py-8 space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
    <div>
      <h1 class="text-3xl font-extrabold tracking-tight">Kalender Acara Saya</h1>
      <p class="mt-2 text-sm text-slate-600 max-w-xl">
        Lihat rangkaian acara dari berbagai komunitas yang Anda ikuti. Manfaatkan kalender ini
        untuk merencanakan kegiatan belajar dan diskusi Anda.
      </p>
    </div>
  </div>

  @if($events->isEmpty())
    {{-- State kosong --}}
    <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center">
      <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 mb-3">
        📅
      </div>
      <h2 class="text-base font-semibold text-slate-800">Belum ada acara terdaftar</h2>
      <p class="mt-1 text-sm text-slate-500 max-w-md mx-auto">
        Tambahkan acara dari halaman detail komunitas. Acara yang Anda buat atau ikuti akan muncul di sini.
      </p>
    </div>
  @else
    {{-- Wrapper daftar acara --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 sm:p-6 space-y-4">

      {{-- Optional: ringkasan singkat --}}
      <div class="flex items-center justify-between pb-3 border-b border-slate-100">
        <div class="flex items-center gap-2 text-sm text-slate-600">
          <span class="inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
            📆
          </span>
          <span>
            Anda memiliki <span class="font-semibold text-slate-800">{{ $events->count() }}</span>
            acara terjadwal.
          </span>
        </div>
      </div>

      {{-- Daftar event --}}
      <div class="space-y-4">
        @foreach($events as $event)
          @php
            $date = \Carbon\Carbon::parse($event->event_date);
            $community = $event->community ?? null;
            $isOwner = $community && auth()->check() && $community->owner_id === auth()->id();
          @endphp

          <div class="flex gap-4 items-stretch">
            {{-- Badge tanggal --}}
            <div class="flex flex-col items-center justify-center px-3 py-2 rounded-2xl bg-slate-50 border border-slate-200 min-w-[70px]">
              <span class="text-[11px] font-medium uppercase tracking-wide text-slate-500">
                {{ $date->format('M') }}
              </span>
              <span class="text-xl font-bold text-slate-900 leading-none">
                {{ $date->format('d') }}
              </span>
              <span class="mt-1 text-[10px] text-slate-400">
                {{ $date->format('D') }}
              </span>
            </div>

            {{-- Card utama event --}}
            <div class="flex-1 bg-slate-50/80 rounded-2xl border border-slate-200 px-4 py-3 flex items-start justify-between gap-3 hover:bg-slate-50 transition">
              <div class="space-y-1">
                <p class="text-sm font-semibold text-slate-900">
                  {{ $event->title }}
                </p>

                <p class="text-xs text-slate-500">
                  {{ $date->format('d M Y') }}
                  @if($event->start_time)
                    • {{ substr($event->start_time, 0, 5) }} WIB
                  @endif
                  @if($event->end_time)
                    – {{ substr($event->end_time, 0, 5) }} WIB
                  @endif
                </p>

                @if($event->location)
                  <p class="text-xs text-slate-500">
                    📍 {{ $event->location }}
                  </p>
                @endif

                @if($event->description)
                  <p class="text-xs text-slate-600 mt-1 line-clamp-2">
                    {{ $event->description }}
                  </p>
                @endif
              </div>

              <div class="flex flex-col items-end gap-2 text-[11px]">
                {{-- info komunitas pemilik acara --}}
                @if($community)
                  <span class="text-[11px] text-slate-500 mb-1 text-right">
                    Komunitas:
                    <span class="font-semibold text-slate-800">
                      {{ $community->name }}
                    </span>
                    @if($isOwner)
                      <span class="ml-1 inline-flex px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px]">
                        Admin
                      </span>
                    @endif
                  </span>
                @endif

                <a href="{{ route('komunitas.show', $event->community_id) }}"
                   class="px-3 py-1 rounded-full border border-emerald-600 text-emerald-700 font-semibold hover:bg-emerald-50">
                  Lihat Komunitas
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
