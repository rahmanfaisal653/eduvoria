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
    </div>
  </div>

  {{-- KPI cards --}}
  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
    @foreach ($kpis as $card)
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 relative overflow-hidden">
        <p class="text-sm text-slate-500">{{ $card['title'] }}</p>
        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ number_format($card['value']) }}</p>
      </div>
    @endforeach
  </div>

  <div class="mt-6 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-slate-800">Ringkasan Interaksi (Orang lain → Anda)</h3>
    <div class="mt-4">
      <canvas id="statsBar" class="w-full" height="120"></canvas>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    (function () {
      const stats = @json($stats ?? []);
      const el = document.getElementById('statsBar');
      if (!el || !stats || Object.keys(stats).length === 0) return;

      new Chart(el, {
        type: 'bar',
        data: {
          labels: ['Pengikut', 'Views', 'Like', 'Reply'],
          datasets: [{
            label: 'Total',
            data: [stats.followers ?? 0, stats.views ?? 0, stats.likes ?? 0, stats.replies ?? 0],
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
          },
          scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
          }
        }
      });
    })();
  </script>
@endpush
