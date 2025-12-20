@extends('layouts.appadmin')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')
    <section class="space-y-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengguna Aktif</h2>

        {{-- Kontrol Filter/Pencarian --}}
        <div class="bg-white p-4 rounded-xl shadow-md flex justify-between items-center space-x-4">
            <input
                type="text"
                placeholder="Cari berdasarkan Nama atau Email..."
                class="w-full max-w-sm rounded-lg border border-gray-300 py-2 px-3 text-sm focus:border-teal-500 focus:ring-teal-500"
            />               

            {{-- Tombol Tambah Pengguna --}}

            <button id="add-user-btn" class="bg-teal-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-teal-700">
                Tambah Pengguna Baru
            </button>
        </div>

        {{-- Tabel Pengguna --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Menggunakan data $users yang dikirim dari Controller --}}
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50" data-user-id="{{ $user->id }}">
                        
                        {{-- 1. NAMA (Ganti 'name' jadi 'username' sesuai database, hapus tanda kutip) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $user->name }}
                        </td>

                        {{-- 2. EMAIL --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </td>

                        {{-- 3. STATUS (Kita buat logika warna sederhana di sini) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColor = $user->status === 'active' 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-red-100 text-red-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        {{-- 4. TANGGAL BERGABUNG (Pakai created_at bawaan Laravel) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                        </td>

                        {{-- 5. AKSI (Langsung tampilkan tombolnya) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            {{-- Tombol Edit --}}
                            <a href="#" 
                            class="edit-user-btn text-blue-600 hover:text-blue-900" 
                            data-id="{{ $user->id }}" 
                            data-email="{{ $user->email }}" 
                            data-username="{{ $user->name }}"
                            data-status="{{ $user->status}}">
                            Edit
                            </a>

                            <a href="#"
                            class="detail-user-btn text-cyan-600 hover:text-cyan-900"
                            data-id="{{ $user->id }}"
                            data-username="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-status="{{ $user->status }}"
                            data-bio="{{ $user->bio }}"
                            data-hobi="{{ $user->hobi }}"
                            data-role="{{ $user->role }}"
                            data-followers="{{ $user->followers_count }}"
                            data-following="{{ $user->following_count }}">
                            Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- MODAL TAMBAH PENGGUNA --}}
    @include('componentsAdmin.add-user-modal')

    {{-- MODAL EDIT PENGGUNA --}}
    @include('componentsAdmin.edit-user-modal')

    {{-- MODAL BLOKIR PENGGUNA --}}
    @include('componentsAdmin.block-user-modal')

    {{-- MODAL DETAIL PENGGUNA --}}
    @include('componentsAdmin.detail-user-modal')
@endsection



