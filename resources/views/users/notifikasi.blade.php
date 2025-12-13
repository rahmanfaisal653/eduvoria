@extends('layouts.app')

@section('title', 'Notifikasi — Eduvoria')

@section('content')
<div class="max-w-7xl mx-auto">
  {{-- Header + Actions --}}
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Notifikasi Saya</h1>
    <div class="hidden sm:flex items-center gap-3">
      <form action="{{ route('notifikasi.readAll') }}" method="POST">
        @csrf
        <button id="btn-markall"
          class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
          Tandai Semua Sudah Dibaca
        </button>
      </form>
      <select
        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 focus:ring-emerald-500">
        <option>Semua Waktu</option>
        <option>7 Hari</option>
        <option>30 Hari</option>
      </select>
    </div>
  </div>

  <div class="mt-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- LEFT --}}
    <section class="lg:col-span-3 space-y-4">

      {{-- Tabs --}}
      <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="px-4 sm:px-5 py-3 flex items-center gap-4 text-sm">
         <div class="px-4 sm:px-5 py-3 flex items-center gap-4 text-sm">
  <a href="{{ route('notifikasi', ['filter' => 'all']) }}"
     class="tab-btn {{ ($filter ?? 'all')=='all' ? 'font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-px -mb-px leading-none' : 'text-slate-600 hover:text-emerald-700 hover:border-b-2 hover:border-emerald-600 hover:pb-px hover:-mb-px' }}">
    Semua <span class="text-slate-400">({{ $totalCount ?? 0 }})</span>
  </a>

  <a href="{{ route('notifikasi', ['filter' => 'unread']) }}"
     class="tab-btn {{ ($filter ?? 'all')=='unread' ? 'font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-px -mb-px leading-none' : 'text-slate-600 hover:text-emerald-700 hover:border-b-2 hover:border-emerald-600 hover:pb-px hover:-mb-px' }}">
    Baru <span class="text-slate-400">({{ $unreadCount ?? 0 }})</span>
  </a>

  <a href="{{ route('notifikasi', ['filter' => 'read']) }}"
     class="tab-btn {{ ($filter ?? 'all')=='read' ? 'font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-px -mb-px leading-none' : 'text-slate-600 hover:text-emerald-700 hover:border-b-2 hover:border-emerald-600 hover:pb-px hover:-mb-px' }}">
    Sudah Dibaca <span class="text-slate-400">({{ $readCount ?? 0 }})</span>
  </a>
</div>
        </div>
      </div>

      {{-- LIST --}}
      <div id="notif-list" class="space-y-3">

        {{-- ===================== --}}
        {{-- NOTIFIKASI DARI DB --}}
        {{-- ===================== --}}
        @foreach($notifications as $notif)
        <div class="notif-row
          {{ $notif->is_read ? 'bg-slate-50 border-slate-200' : 'bg-white border-emerald-100' }}
          border rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
          data-unread="{{ $notif->is_read ? '0' : '1' }}">

          <div class="flex items-start gap-3">

            {{-- ICON --}}
            <div class="h-8 w-8 rounded-full grid place-items-center
              @if($notif->type=='like') bg-rose-50 text-rose-600
              @elseif($notif->type=='comment') bg-cyan-50 text-cyan-600
              @elseif($notif->type=='follow') bg-emerald-50 text-emerald-600
              @else bg-slate-100 text-slate-600
              @endif">
              @if($notif->type=='like') ❤️
              @elseif($notif->type=='comment') 💬
              @elseif($notif->type=='follow') 👤
              @else 🔔
              @endif
            </div>

            {{-- CONTENT --}}
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">
                  {{ $notif->fromUser->name ?? 'User' }}
                </b>

                @if($notif->type=='like')
                  menyukai postingan Anda.
                @elseif($notif->type=='comment')
                  mengomentari postingan Anda.
                @elseif($notif->type=='follow')
                  mulai mengikuti Anda.
                @endif
              </p>

              <div class="mt-1 flex items-center gap-2">
                <span class="text-xs text-slate-400">
                  {{ $notif->created_at->diffForHumans() }}
                </span>

                @if(!$notif->is_read)
                  <span class="badge-unread inline-flex text-[10px] font-semibold
                    bg-emerald-100 text-emerald-700 rounded-full px-2 py-0.5">
                    Baru
                  </span>
                @endif
              </div>
            </div>

            {{-- ACTION --}}
            @if(!$notif->is_read)
            <form action="{{ route('notifikasi.read', $notif->id) }}" method="POST">
              @csrf
              <button class="btn-markread text-xs text-emerald-700 hover:underline">
                Tandai dibaca
              </button>
            </form>
            @endif

          </div>
        </div>
        @endforeach
      </div>
    </section>

    {{-- RIGHT --}}
    <aside class="hidden lg:block">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="font-bold">Tips Notifikasi</h3>
        <ul class="text-sm list-disc list-inside text-slate-600 mt-2">
          <li>Notifikasi baru ditandai hijau</li>
          <li>Gunakan filter untuk fokus</li>
        </ul>
      </div>
    </aside>
  </div>
</div>

{{-- JS ASLI KAMU (TIDAK DIUBAH) --}}
<script>
  const list = document.getElementById('notif-list');
  document.querySelectorAll('.btn-markread').forEach(btn => {
    btn.addEventListener('click', () => {
      const row = btn.closest('.notif-row');
      row.dataset.unread = '0';
      row.classList.remove('bg-white','border-emerald-100');
      row.classList.add('bg-slate-50','border-slate-200');
      row.querySelector('.badge-unread')?.remove();
    });
  });
</script>
@endsection
