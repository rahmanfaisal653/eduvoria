@extends('layouts.app')

@section('title', 'Edit Postingan — '.$community->name)

@section('content')
<div class="max-w-2xl mx-auto py-6 space-y-4">

  <a href="{{ route('komunitas.show', $community->id) }}"
     class="text-sm text-slate-600 hover:text-slate-800">
    ‹ Kembali ke komunitas
  </a>

  <h1 class="text-2xl font-bold mb-3">Edit Postingan</h1>

  @if($errors->any())
    <div class="mb-4 bg-red-50 text-red-700 px-4 py-2 rounded text-xs">
      @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <form action="{{ route('community-posts.update', [$community->id, $post->id]) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium mb-1">Isi Postingan</label>
      <textarea name="content" rows="4"
                class="w-full border rounded-2xl px-3 py-2 text-sm">{{ old('content', $post->content) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Foto (opsional)</label>

      @if($post->image)
        <img src="{{ asset('uploads/postingan_komunitas/'.$post->image) }}"
             class="h-32 rounded-lg object-cover mb-2">
      @endif

      <input type="file" name="image" class="w-full border rounded px-3 py-2 text-sm">
      <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
    </div>

    <div class="flex gap-3">
      <button type="submit"
              class="px-4 py-2 bg-emerald-600 text-white rounded text-sm font-semibold">
        Simpan Perubahan
      </button>
      <a href="{{ route('komunitas.show', $community->id) }}"
         class="px-4 py-2 border rounded text-sm">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection
