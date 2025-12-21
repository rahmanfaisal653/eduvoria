@extends('layouts.appadmin')

@section('title', 'Laporan Langganan')
@section('page_title', 'Tinjauan Laporan Langganan (Subscription)')

@section('content')
    <section class="space-y-6">
        
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Laporan Masalah Transaksi</h2>

        {{-- Metrik Ringkasan Subscribe (Diambil dari halaman laporan langganan sebelumnya) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Revenue Bulan Ini</p>

                <p class="text-3xl font-bold text-gray-900 mt-1">
                    Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}
                </p>

                <p class="text-sm mt-2 {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $growth >= 0 ? '▲' : '▼' }}
                    {{ number_format(abs($growth), 1) }}% dari Bulan Lalu
                </p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-lg border-b-4 border-cyan-500">
                <p class="text-sm font-medium text-gray-500">Total Pelanggan Aktif</p>
                
                <p class="text-3xl font-bold text-gray-900 mt-1">
                    {{ number_format($totalActiveSubscribers) }}
                </p>

                <p class="text-sm text-green-600 mt-2">
                    @if($newSubscribersThisMonth > 0)
                        ▲ {{ $newSubscribersThisMonth }} Pengguna Baru
                    @else
                        <span class="text-gray-400">0 Pengguna Baru</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Tabel Laporan Subscribe --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-cyan-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Method Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Status Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-cyan-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Loop data $subscribe dari Controller --}}
                    @forelse ($subscribe as $report)
                    <tr class="hover:bg-gray-50" data-subs-id="{{ $report['id_subscribe'] }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report['id_subscribe'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['username'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['start_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report['end_date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucwords(str_replace('_', ' ', $report['payment_method'])) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = strtolower($report['status']);
                                if ($status == 'paid' || $status == 'paid') {
                                    $color = 'bg-green-100 text-green-800';
                                } elseif ($status == 'pending') {
                                    $color = 'bg-yellow-100 text-yellow-800';
                                } elseif ($status == 'failed') {
                                    $color = 'bg-red-100 text-red-800';
                                } else {
                                    $color = 'bg-gray-100 text-gray-800';
                                }
                            @endphp

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ $report['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button 
                                type="button"
                                class="subs-trigger text-cyan-600 hover:text-cyan-900 font-semibold"
                                data-id="{{ $report['id_subscribe'] }}"
                                data-username="{{ $report['username'] }}" 
                                data-start-date="{{ $report['start_date'] }}"
                                data-end-date="{{ $report['end_date'] }}"
                                data-status="{{ $report['status'] }}"
                                data-price="{{ $report['price'] }}"
                                data-payment-method="{{ $report['payment_method'] }}"
                            >
                                Detail
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan langganan yang bermasalah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Detail Laporan Subscribe --}}
    @include('componentsAdmin.detail-subcription-modal')

@endsection

