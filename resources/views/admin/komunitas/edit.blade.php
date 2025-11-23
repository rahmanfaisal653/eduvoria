@extends('layouts.appadmin')

@section('title', 'Edit Komunitas — '.$community->name)

@section('content')
<div class="px-6 py-6 max-w-3xl space-y-4">

  <a href="{{ route('admin.komunitas.index') }}"
     class="text-sm text-slate-600 hover:text-slate-800 inline-flex items-center gap-1">
    ‹ Kembali ke Kelola Komunitas
  </a>

  <h1 class="text-3xl font-extrabold tracking-tight mb-2">Edit Komunitas</h1>

  @if($errors->any())
    <div class="bg-red-50 text-red-700 px-4 py-3 rounded-2xl text-xs mb-2">
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 space-y-4">
    <form action="{{ route('admin.komunitas.update', $community->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium mb-1">Nama Komunitas</label>
        <input type="text" name="name"
               value="{{ old('name', $community->name) }}"
               class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="description" rows="4"
                  class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $community->description) }}</textarea>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Kategori</label>
          <input type="text" name="category"
                 value="{{ old('category', $community->category) }}"
                 class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Jumlah Anggota</label>
          <input type="number" name="members_count"
                 value="{{ old('members_count', $community->members_count) }}"
                 class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Foto Profil</label>
          @if($community->profile_image)
            <img src="{{ asset('uploads/komunitas/'.$community->profile_image) }}"
                 class="h-16 w-16 rounded-full object-cover mb-2">
          @endif
          <input type="file" name="profile_image"
                 class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Background Komunitas</label>
          @if($community->background_image)
            <img src="{{ asset('uploads/komunitas/'.$community->background_image) }}"
                 class="h-20 rounded-2xl object-cover mb-2">
          @endif
          <input type="file" name="background_image"
                 class="w-full border border-slate-300 rounded-2xl px-4 py-2.5 text-sm">
        </div>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="submit"
                class="px-5 py-2.5 bg-emerald-600 text-white rounded-2xl text-sm font-semibold hover:bg-emerald-700">
          Simpan Perubahan
        </button>
        <a href="{{ route('admin.komunitas.index') }}"
           class="px-5 py-2.5 border border-slate-300 rounded-2xl text-sm text-slate-700 hover:bg-slate-50">
          Batal
        </a>
      </div>
    </form>
  </div>

</div>
@endsection
