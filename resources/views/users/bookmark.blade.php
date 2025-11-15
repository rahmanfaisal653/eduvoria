@extends('layouts.app')

@section('title', 'Bookmark Saya - Eduvoria')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Simpanan Saya (Bookmark) 🔖</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- SIDEBAR KATEGORI -->
        <aside class="lg:col-span-1 space-y-4">
            <div class="bg-white p-5 rounded-xl shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Kategori</h2>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg bg-teal-50 text-teal-700 font-semibold">
                            Semua Item <span class="text-xs font-normal">(5)</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-100">
                            Desain & UI/UX <span class="text-xs font-normal">(2)</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-100">
                            Tips Karir <span class="text-xs font-normal">(1)</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-100">
                            Traveling <span class="text-xs font-normal">(2)</span>
                        </a>
                    </li>
                </ul>

                <button class="w-full mt-4 text-sm font-semibold text-teal-600 hover:text-teal-800 border-t border-gray-100 pt-3">
                    + Buat Kategori Baru
                </button>
            </div>
        </aside>

        <!-- LIST BOOKMARK -->
        <section class="lg:col-span-3 space-y-6">
            @foreach ($bookmarks as $key => $value)
                <div class="bg-white p-5 rounded-xl shadow-lg border-l-4 border-cyan-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="h-8 w-8 rounded-full bg-pink-400 flex-shrink-0"></div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $value['nama'] }}</p>
                                    <p class="text-xs text-gray-500">Disimpan {{ $value['waktu'] }} hari yang lalu</p>
                                </div>
                            </div>
                            <p class="mt-3 text-gray-700">{{ $value['isi'] }}</p>
                            <div class="mt-2 text-xs font-medium text-teal-600">#Desain & UI/UX</div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-1">
                            <button class="text-gray-400 hover:text-red-500 text-lg">&times;</button>
                            <span class="text-sm text-gray-500 mt-2">❤ {{ $value['like'] }}</span>
                            <span class="text-sm text-gray-500">💬 {{ $value['komentar'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection