@extends('layouts.appadmin')

@section('title', 'Konten & Postingan')
@section('page_title', 'Manajemen Konten & Postingan')

@section('content')
    <section class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Konten Publik</h2>

        {{-- Metrik Konten --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Total Postingan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">15.8K</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Postingan Gambar/Video</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">9.2K</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Perlu Review Cepat</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
            </div>
        </div>

        {{-- Tambah Postingan --}}
        <div class="mb-4 flex justify-end">
            <button id="add-post-btn" class="bg-teal-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-teal-700">
                Tambah Postingan
            </button>
        </div>

        {{-- Tabel Postingan --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cyan-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Foto Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Menggunakan data $posts dari Controller --}}
                    @forelse ($posts as $post)
                    <tr class="hover:bg-gray-50">
                        
                        {{-- 1. ID POSTINGAN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            #{{ $post->id }}
                        </td>

                        {{-- 2. KONTEN (Dibatasi 40 karakter) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ Str::limit($post->content, 40) }}
                        </td>

                        {{-- 3. PENULIS (MEMPERBAIKI: Menggunakan Relasi 'user' untuk mendapatkan 'name') --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $post->user->name }}
                        </td>

                        {{-- 4. Foto Konten --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{-- Cek apakah post memiliki gambar (image) --}}
                            @if ($post->image)
                                <a href="{{ asset('storage/' . $post->image) }}" target="_blank" >
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="Foto Konten #{{ $post->id }}" 
                                         class="h-10 w-10 object-cover rounded-md shadow-sm">
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada foto</span>
                            @endif
                        </td>

                        {{-- 5. STATUS (Logika Warna) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Tentukan warna berdasarkan status
                                $colorClass = 'bg-gray-100 text-gray-800'; // Default
                                if($post->status == 'active') $colorClass = 'bg-green-100 text-green-800';
                                if($post->status == 'inactive') $colorClass = 'bg-purple-100 text-purple-800';
                                if($post->status == 'archived') $colorClass = 'bg-yellow-100 text-yellow-800';
                                if($post->status == 'reported') $colorClass = 'bg-red-100 text-red-800';
                            @endphp
                            
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>

                        {{-- 6. AKSI --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">

                        <a href="#" 
                        class="edit-post-btn text-blue-600 hover:text-blue-900" 
                        data-id="{{ $post->id }}"
                        data-content="{{ $post->content }}"
                        data-user-id="{{ $post->user_id }}" 
                        data-user-name="{{ $post->user->name }}" 
                        data-status="{{ $post->status }}">
                        Edit
                        </a>

                        <a href="#"
                        class= "detail-post-btn inline-flex items-center justify-center
                        text-white bg-cyan-600 hover:bg-cyan-700 py-1 px-3 rounded text-xs"
                        data-id="{{ $post->id }}"
                        data-content="{{ $post->content }}"
                        data-user-id="{{ $post->user_id }}" 
                        data-user-name="{{ $post->user->name }}"
                        data-image-url="{{ $post->image ? asset('storage/' . $post->image) : '' }}"
                        data-status="{{ $post->status }}"
                        data-likes="{{ $post->likes_count }}"
                        data-bookmark="{{ $post->bookmarks_count }}"
                        data-view="{{ $post->views_count }}"
                        >
                        Detail
                        </a>

                        {{-- Tombol HAPUS --}}
                        <a href="{{ route('admin.content.delete', $post->id) }}" 
                        class="text-red-600 hover:text-red-900 font-semibold cursor-pointer"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');"> {{-- Tambahkan konfirmasi --}}
                        Delete
                        </a>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada postingan untuk ditampilkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    
    {{-- Modal Komponen --}}
    @include('componentsAdmin.edit-post-modal')
    @include('componentsAdmin.add-post-modal')

@endsection
