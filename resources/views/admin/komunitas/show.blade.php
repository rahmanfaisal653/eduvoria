@extends('layouts.appadmin')

@section('title', 'Detail Komunitas — '.$community->name)

@section('content')
<div class="px-6 py-6 space-y-4">

  <a href="{{ route('admin.komunitas.index') }}"
     class="text-sm text-slate-600 hover:text-slate-800 inline-flex items-center gap-1">
    ‹ Kembali ke Kelola Komunitas
  </a>

  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
   
    @if($community->background_image)
      @php
        // ✅ tambahan: prioritas storage link, fallback ke uploads lama
        $bgStorage = asset('storage/komunitas/'.$community->background_image);
        $bgUploads = asset('uploads/komunitas/'.$community->background_image);
      @endphp

      <div class="h-40 bg-cover bg-center"
           style="background-image: url('{{ $bgStorage }}')"
           onerror="this.onerror=null; this.style.backgroundImage='url({{ $bgUploads }})';">
      </div>
    @else
      <div class="h-32 bg-slate-100"></div>
    @endif

    <div class="p-6 space-y-4">
      <div class="flex items-center gap-4 -mt-10">
        @if($community->profile_image)
          @php
            // ✅ tambahan: prioritas storage link, fallback ke uploads lama
            $pfStorage = asset('storage/komunitas/'.$community->profile_image);
            $pfUploads = asset('uploads/komunitas/'.$community->profile_image);
          @endphp

          <img src="{{ asset('uploads/komunitas/'.$community->profile_image) }}"
               class="h-16 w-16 rounded-full border-4 border-white object-cover"
               onerror="this.onerror=null; this.src='{{ $pfStorage }}'; this.onerror=function(){this.onerror=null; this.src='{{ $pfUploads }}';};">
        @else
          <div class="h-16 w-16 rounded-full border-4 border-white bg-slate-100 flex items-center justify-center text-xl text-slate-500">
            {{ strtoupper(substr($community->name,0,1)) }}
          </div>
        @endif

        <div>
          <h1 class="text-2xl font-bold text-slate-900">{{ $community->name }}</h1>
          <p class="text-xs text-slate-500">
            Kategori: {{ $community->category ?? '-' }} • Slug: {{ $community->slug }}
          </p>
        </div>
      </div>

      <div>
        <h2 class="text-sm font-semibold text-slate-800 mb-1">Deskripsi</h2>
        <p class="text-sm text-slate-600">
          {{ $community->description ?: 'Belum ada deskripsi.' }}
        </p>
      </div>

      <div class="flex flex-wrap gap-4 text-xs text-slate-600">
        <span>Owner ID: {{ $community->owner_id }}</span>
        <span>Anggota: {{ $community->members_count }}</span>
        <span>Dibuat: {{ $community->created_at->format('d M Y') }}</span>
        <span>Terakhir update: {{ $community->updated_at->format('d M Y H:i') }}</span>
      </div>

      <div class="flex gap-3 pt-2">
        <a href="{{ route('admin.komunitas.edit', $community->id) }}"
           class="px-4 py-2 text-sm rounded-2xl bg-sky-600 text-white font-semibold hover:bg-sky-700">
          Edit Komunitas
        </a>
        <form action="{{ route('admin.komunitas.destroy', $community->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus komunitas ini?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="px-4 py-2 text-sm rounded-2xl bg-red-600 text-white font-semibold hover:bg-red-700">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection
