@extends('layouts.appadmin')

@section('title', 'Kelola Komunitas — Eduvoria Admin')

@section('content')
<div class="px-6 py-6 space-y-6">


  <div>
    <h1 class="text-3xl font-extrabold tracking-tight">Manajemen Komunitas</h1>
    <p class="mt-2 text-sm text-slate-600">
      Kelola seluruh komunitas yang dibuat oleh pengguna di platform Eduvoria.
    </p>
  </div>

 
  @if(session('success'))
    <div class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-xl text-sm">
      {{ session('success') }}
    </div>
  @endif

 
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 px-6 py-4">
      <p class="text-xs font-semibold text-slate-500 mb-1">Total Komunitas</p>
      <p class="text-2xl font-extrabold text-slate-900">{{ $totalCommunities }}</p>
      <p class="text-[11px] text-slate-500 mt-1">Semua komunitas yang terdaftar</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 px-6 py-4">
      <p class="text-xs font-semibold text-slate-500 mb-1">Total Anggota Komunitas</p>
      <p class="text-2xl font-extrabold text-slate-900">{{ number_format($totalMembers) }}</p>
      <p class="text-[11px] text-slate-500 mt-1">Akumulasi anggota di semua komunitas</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 px-6 py-4">
      <p class="text-xs font-semibold text-slate-500 mb-1">Perlu Review Cepat</p>
      <p class="text-2xl font-extrabold text-slate-900">{{ $needReview }}</p>
      <p class="text-[11px] text-slate-500 mt-1">Laporan komunitas (placeholder)</p>
    </div>
  </div>


  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-3 bg-sky-50 border-b border-slate-200 text-xs font-semibold text-slate-600 grid grid-cols-12">
      <div class="col-span-2">ID</div>
      <div class="col-span-4">Komunitas</div>
      <div class="col-span-2">Pemilik (ID)</div>
      <div class="col-span-2">Anggota</div>
      <div class="col-span-2">Aksi</div>
    </div>

    @forelse($communities as $community)
      <div class="px-6 py-3 border-b border-slate-100 text-sm grid grid-cols-12 items-center hover:bg-slate-50">
        <div class="col-span-2 text-xs text-slate-500">
          #{{ $community->id }}
        </div>

        <div class="col-span-4">
          <div class="font-semibold text-slate-900">
            {{ $community->name }}
          </div>
          <div class="text-xs text-slate-500 truncate">
            {{ $community->description }}
          </div>
        </div>

        <div class="col-span-2 text-xs text-slate-600">
          ID Owner: {{ $community->owner_id }}
        </div>

        <div class="col-span-2 text-xs text-slate-600">
          {{ $community->members_count }} anggota
        </div>

        <div class="col-span-2 text-xs flex items-center gap-3">
          <a href="{{ route('admin.komunitas.show', $community->id) }}"
             class="text-emerald-700 font-semibold hover:underline">
            Lihat
          </a>

          <a href="{{ route('admin.komunitas.edit', $community->id) }}"
             class="text-sky-700 font-semibold hover:underline">
            Edit
          </a>

          <form action="{{ route('admin.komunitas.destroy', $community->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus komunitas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="text-red-600 font-semibold hover:underline">
              Hapus
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="px-6 py-4 text-sm text-slate-500">
        Belum ada komunitas yang terdaftar.
      </div>
    @endforelse
  </div>

</div>
@endsection
