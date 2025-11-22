@extends('layouts.app')

@section('title', 'Edit Acara — '.$community->name)

@section('content')
<div class="max-w-3xl mx-auto py-8 space-y-6">

  {{-- Link kembali --}}
  <a href="{{ route('komunitas.show', $community->id) }}"
     class="text-sm text-slate-600 hover:text-slate-800 inline-flex items-center gap-1">
    ‹ Kembali ke komunitas
  </a>

  {{-- Judul halaman --}}
  <div>
    <h1 class="text-3xl font-extrabold tracking-tight mb-1">Edit Acara</h1>
    <p class="text-sm text-slate-600">
      Ubah informasi acara yang terjadwal di komunitas <span class="font-semibold">{{ $community->name }}</span>.
    </p>
  </div>

  {{-- Error validasi --}}
  @if($errors->any())
    <div class="bg-red-50 text-red-700 px-4 py-3 rounded-2xl text-xs mb-2">
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  {{-- Kartu form utama --}}
  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sm:p-8">
    <form action="{{ route('community-events.update', [$community->id, $event->id]) }}"
          method="POST"
          class="space-y-5">
      @csrf
      @method('PUT')

      {{-- Judul --}}
      <div>
        <label class="block text-sm font-medium text-slate-800 mb-1">Judul Acara</label>
        <input
          type="text"
          name="title"
          value="{{ old('title', $event->title) }}"
          class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
          required>
      </div>

      {{-- Deskripsi --}}
      <div>
        <label class="block text-sm font-medium text-slate-800 mb-1">Deskripsi</label>
        <textarea
          name="description"
          rows="4"
          class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
          placeholder="Tambahkan informasi singkat mengenai acara (opsional)">{{ old('description', $event->description) }}</textarea>
      </div>

      {{-- Tanggal & Jam mulai --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-slate-800 mb-1">Tanggal</label>
          <input
            type="date"
            name="event_date"
            value="{{ old('event_date', $event->event_date) }}"
            class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
            required>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-800 mb-1">Jam Mulai (opsional)</label>
          <input
            type="time"
            name="start_time"
            value="{{ old('start_time', $event->start_time) }}"
            class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
      </div>

      {{-- Jam selesai --}}
      <div>
        <label class="block text-sm font-medium text-slate-800 mb-1">Jam Selesai (opsional)</label>
        <input
          type="time"
          name="end_time"
          value="{{ old('end_time', $event->end_time) }}"
          class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
      </div>

      {{-- Lokasi --}}
      <div>
        <label class="block text-sm font-medium text-slate-800 mb-1">Lokasi (opsional)</label>
        <input
          type="text"
          name="location"
          value="{{ old('location', $event->location) }}"
          class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
          placeholder="Contoh: Zoom, Ruang A-101, atau link meeting">
      </div>

      {{-- Tombol aksi --}}
      <div class="flex flex-wrap items-center gap-3 pt-2">
        <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 text-white rounded-2xl text-sm font-semibold hover:bg-emerald-700">
          Simpan Perubahan
        </button>

        <a href="{{ route('komunitas.show', $community->id) }}"
           class="px-5 py-2.5 border border-slate-300 rounded-2xl text-sm text-slate-700 hover:bg-slate-50">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
