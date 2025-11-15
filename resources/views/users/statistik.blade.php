@extends('layouts.app')

@section('title', 'Dashboard Statistik — Eduvoria')

@section('content')
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-extrabold tracking-tight">Dashboard Statistik 📊</h1>

    <div class="flex items-center gap-3">
      <select class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
        <option>7 Hari Terakhir</option>
        <option>30 Hari Terakhir</option>
        <option>90 Hari Terakhir</option>
      </select>
      <button class="rounded-xl bg-emerald-700 text-white px-4 py-2 text-sm font-semibold hover:bg-emerald-800">
        Unduh Laporan
      </button>
    </div>
  </div>

  {{-- KPI cards --}}
  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
    @foreach ($kpis as $card)
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden">
        <div class="absolute left-0 top-0 h-full w-1 {{ $card['trend']==='up' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
        <p class="text-sm text-slate-500">{{ $card['title'] }}</p>
        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $card['value'] }}</p>
        <p class="mt-1 text-xs {{ $card['trend']==='up' ? 'text-emerald-600' : 'text-rose-600' }}">
          {{ $card['trend']==='up' ? '▲' : '▼' }} {{ $card['delta'] }}
          <span class="text-slate-500">{{ $card['delta_desc'] }}</span>
        </p>
      </div>
    @endforeach
  </div>

  {{-- Charts area (placeholder) --}}
  <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
      <h3 class="text-lg font-semibold text-slate-800">Tren Interaksi (Suka & Komentar)</h3>
      <div class="mt-4 rounded-xl border border-slate-200 h-72 grid place-items-center text-slate-500 text-sm">
        [Area Grafik Tren Garis/Area akan ditampilkan di sini]
        <div class="mt-2">
          <span class="font-semibold text-emerald-700">Data Suka (Teal)</span> |
          <span class="font-semibold text-cyan-700">Data Komentar (Cyan)</span>
        </div>
      </div>

      {{-- Data tabel kecil --}}
      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-xs">
          <thead>
            <tr class="text-left text-slate-500">
              <th class="py-2 pr-4">Hari</th>
              @foreach ($trend['labels'] as $lbl)
                <th class="py-2 px-3">{{ $lbl }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="py-2 pr-4 font-medium text-slate-700">Suka</td>
              @foreach ($trend['likes'] as $v)
                <td class="py-2 px-3">{{ $v }}</td>
              @endforeach
            </tr>
            <tr>
              <td class="py-2 pr-4 font-medium text-slate-700">Komentar</td>
              @foreach ($trend['comments'] as $v)
                <td class="py-2 px-3">{{ $v }}</td>
              @endforeach
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
      <h3 class="text-lg font-semibold text-slate-800">Sumber Traffic Halaman</h3>
      <div class="mt-4 rounded-xl border border-slate-200 h-72 grid place-items-center text-slate-500 text-sm">
        [Area Grafik Donut/Pie akan ditampilkan di sini]
      </div>

      <ul class="mt-4 space-y-2 text-sm">
        @foreach ($traffic as $t)
          <li class="flex items-center justify-between">
            <span class="text-slate-700">{{ $t['label'] }}</span>
            <span class="font-semibold text-slate-900">{{ $t['value'] }}%</span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection
