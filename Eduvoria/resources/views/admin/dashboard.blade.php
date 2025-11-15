@extends('layouts.appadmin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin Utama')

@section('content')
    
    <!-- 1. KARTU METRIK UTAMA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Kartu 1: Total Pengguna (Teal) -->
        <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-teal-500">
            <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">12,500</p>
            <p class="text-sm text-green-600 mt-2">▲ 3.5% Bulan Ini</p>
        </div>

        <!-- Kartu 2: Postingan Baru (Cyan) -->
        <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-cyan-500">
            <p class="text-sm font-medium text-gray-500">Postingan Baru Hari Ini</p>
            <p class="3xl font-bold text-gray-900 mt-1">420</p>
            <p class="text-sm text-green-600 mt-2">▲ 15% dari Kemarin</p>
        </div>

        <!-- Kartu 3: Pelaporan Baru (Red) -->
        <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-red-500">
            <p class="text-sm font-medium text-gray-500">Pelaporan Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">28</p>
            <p class="text-sm text-red-600 mt-2">Segera Tangani!</p>
        </div>

        <!-- Kartu 4: Komunitas Aktif (Indigo) -->
        <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Komunitas Aktif</p>
            <p class="3xl font-bold text-gray-900 mt-1">15</p>
            <p class="text-sm text-gray-600 mt-2">Room dengan >100 anggota</p>
        </div>
    </div>

    <!-- 2. TUGAS DAN LOG AKTIVITAS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KIRI/TENGAH: Daftar Tugas Admin (lg:col-span-2) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Tugas Prioritas Admin</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($tasks as $task)
                <!-- Looping Tugas -->
                <li class="flex justify-between items-center py-3">
                    <div>
                        <p class="font-medium text-gray-900">{{ $task['title'] }}</p>
                        <p class="text-sm {{ $task['color_class'] }}">{{ $task['subtitle'] }}</p>
                    </div>
                    <a href="{{ $task['route'] }}" class="bg-{{ $task['button_color'] }}-500 text-white py-1 px-3 text-xs rounded-full hover:bg-{{ $task['button_color'] }}-600">
                        {{ $task['action'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- KANAN: Log Aktivitas Terbaru -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Log Aktivitas Terbaru</h2>
            <ul class="space-y-4 text-sm">
                @foreach ($logs as $log)
                <!-- Looping Log -->
                <li class="border-l-2 border-{{ $log['color'] }}-500 pl-3">
                    <p class="text-gray-800">{{ $log['description'] }}</p>
                    <p class="text-xs text-gray-500">Oleh Admin: {{ $log['admin'] }} - {{ $log['time'] }}</p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
