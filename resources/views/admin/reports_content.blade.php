@extends('layouts.appadmin')

@section('title', 'Laporan Pelanggaran Konten')
@section('page_title', 'Tinjauan Laporan Pelanggaran')

@section('content')
    <section class="space-y-6">
        
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Laporan yang Perlu Ditindaklanjuti</h2>

        {{-- Metrik Ringkasan Laporan --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Laporan Prioritas Tinggi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">5</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-orange-500">
                <p class="text-sm font-medium text-gray-500">Perlu Review Cepat</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">12</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Total Laporan Aktif</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">28</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Kasus Selesai Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">7</p>
            </div>
        </div>

        {{-- Tabel Laporan Pelanggaran --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">ID Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Tipe Pelanggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Loop data $reports dari Controller --}}
                    @forelse ($reports as $report)
                    <tr class="hover:bg-gray-50">
                        
                        {{-- 1. ID LAPORAN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            #{{ $report->id }}
                        </td>

                        {{-- 2. TIPE PELANGGARAN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report->type }}
                        </td>

                        {{-- 3. TARGET (Kita ambil dari content_summary) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ Str::limit($report->content_summary, 30) }}
                            <div class="text-xs text-gray-400 mt-1">Oleh: {{ $report->reported_by }}</div>
                        </td>

                        {{-- 4. PRIORITAS (Logika Warna Manual) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Tentukan warna berdasarkan priority (High/Medium/Low)
                                $pColor = 'bg-gray-100 text-gray-800'; // Default (Low)
                                
                                if($report->priority == 'High') {
                                    $pColor = 'bg-red-100 text-red-800';
                                } elseif($report->priority == 'Medium') {
                                    $pColor = 'bg-yellow-100 text-yellow-800';
                                }
                            @endphp

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pColor }}">
                                {{ ucfirst($report->priority) }}
                            </span>
                        </td>

                        {{-- 5. AKSI REVIEW --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            {{-- TOMBOL EDIT --}}
                            <button type="button"
                                    class="edit-report-btn text-blue-600 hover:text-blue-900 font-semibold"
                                    data-id="{{ $report->id }}"
                                    data-type="{{ $report->type }}"
                                    data-priority="{{ $report->priority }}"
                                    data-description="{{ $report->description }}">
                                Edit
                            </button>

                            {{-- 3. TOMBOL HAPUS LANGSUNG (Kode Kamu) --}}
                            <a href="{{ route('admin.reports.delete', $report->id) }}" 
                            onclick="return confirm('Yakin hapus laporan ini?')"
                            class="text-red-600 hover:text-red-900 cursor-pointer">
                            Hapus
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada laporan aktif saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- MODAL AKSI PELANGGARAN (Review/Tindak) akan diletakkan di sini --}}
    @include('componentsAdmin.edit-reports-modal')

@endsection

