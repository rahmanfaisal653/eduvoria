@extends('layouts.app')

@section('title', 'Edit Komunitas')

@section('content')
<div class="max-w-2xl mx-auto py-6">

  <h1 class="text-2xl font-bold mb-4">Edit Komunitas</h1>

  @if($errors->any())
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded">
      <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('komunitas.update', $community->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white border rounded-2xl shadow-sm p-6 space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block font-medium text-sm mb-1">Nama Komunitas</label>
      <input type="text" name="name" class="w-full border rounded px-3 py-2 text-sm"
             value="{{ $community->name }}" required>
    </div>

    <div>
      <label class="block font-medium text-sm mb-1">Deskripsi</label>
      <textarea name="description" rows="4" class="w-full border rounded px-3 py-2 text-sm">
{{ $community->description }}</textarea>
    </div>

    <div>
      <label class="block font-medium text-sm mb-1">Kategori</label>
      <input type="text" name="category" class="w-full border rounded px-3 py-2 text-sm"
             value="{{ $community->category }}">
    </div>

    <div>
      <label class="block font-medium text-sm mb-1">Foto Profil Komunitas</label>
      
      @if($community->profile_image)
        <img src="{{ asset('uploads/komunitas/'.$community->profile_image) }}"
             class="h-16 w-16 rounded-full object-cover mb-2">
      @endif

      <input type="file" name="profile_image" class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
      <label class="block font-medium text-sm mb-1">Background Komunitas</label>

      @if($community->background_image)
        <img src="{{ asset('uploads/komunitas/'.$community->background_image) }}"
             class="h-24 rounded-lg object-cover mb-2">
      @endif

      <input type="file" name="background_image" class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-3">
      <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded text-sm font-semibold">
        Perbarui
      </button>
      <a href="{{ route('komunitas.index') }}" class="px-4 py-2 border rounded text-sm">
        Batal
      </a>
    </div>

  </form>

</div>
@endsection
