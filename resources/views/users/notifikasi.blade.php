@extends('layouts.app')

@section('title', 'Notifikasi — Eduvoria')

@section('content')
<div class="max-w-7xl mx-auto">
  {{-- Header + Actions --}}
  <div class="flex items-center justify-between">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Notifikasi Saya</h1>
    <div class="hidden sm:flex items-center gap-3">
      <button id="btn-markall"
        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
        Tandai Semua Sudah Dibaca
      </button>
      <select
        class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 focus:ring-emerald-500">
        <option>Semua Waktu</option>
        <option>7 Hari</option>
        <option>30 Hari</option>
      </select>
    </div>
  </div>

  <div class="mt-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- LEFT: List --}}
    <section class="lg:col-span-3 space-y-4">
      {{-- Filter Tabs --}}
      <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="px-4 sm:px-5 py-3 flex items-center gap-4 text-sm">
          <button id="tab-all"
                  class="tab-btn font-semibold text-emerald-700 border-b-2 border-emerald-600 pb-px -mb-px leading-none">
            Semua <span class="text-slate-400">(15)</span>
          </button>
          <button id="tab-new"
                  class="tab-btn text-slate-600 hover:text-emerald-700 hover:border-b-2 hover:border-emerald-600 hover:pb-px hover:-mb-px">
            Baru <span class="text-slate-400">(3)</span>
          </button>
          <button id="tab-read"
                  class="tab-btn text-slate-600 hover:text-emerald-700 hover:border-b-2 hover:border-emerald-600 hover:pb-px hover:-mb-px">
            Sudah Dibaca
          </button>
          <div class="ml-auto sm:hidden">
            <button id="btn-markall-sm"
              class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700">
              Tandai Semua
            </button>
          </div>
        </div>
      </div>

      {{-- LIST --}}
      <div id="notif-list" class="space-y-3">
        {{-- 1: NEW Like --}}
        <div class="notif-row bg-white border border-emerald-100 rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
             data-unread="1">
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-rose-50 text-rose-600 grid place-items-center">❤️</div>
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">Dewi Lestari</b>
                menyukai postingan Anda.
              </p>
              <div class="mt-1 flex items-center gap-2">
                <span class="text-xs text-slate-400">5m yang lalu</span>
                <span class="badge-unread inline-flex items-center text-[10px] font-semibold bg-emerald-100 text-emerald-700 rounded-full px-2 py-0.5">Baru</span>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <button class="btn-markread text-xs text-emerald-700 hover:underline">Tandai dibaca</button>
              <button class="btn-remove text-xs text-slate-400 hover:text-rose-600">✕</button>
            </div>
          </div>
        </div>

        {{-- 2: NEW Comment --}}
        <div class="notif-row bg-white border border-emerald-100 rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
             data-unread="1">
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-cyan-50 text-cyan-600 grid place-items-center">💬</div>
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">Budi Santoso</b>
                mengomentari: "Ide yang bagus!"
              </p>
              <div class="mt-1 flex items-center gap-2">
                <span class="text-xs text-slate-400">1j yang lalu</span>
                <span class="badge-unread inline-flex items-center text-[10px] font-semibold bg-emerald-100 text-emerald-700 rounded-full px-2 py-0.5">Baru</span>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <button class="btn-markread text-xs text-emerald-700 hover:underline">Tandai dibaca</button>
              <button class="btn-remove text-xs text-slate-400 hover:text-rose-600">✕</button>
            </div>
          </div>
        </div>

        {{-- 3: NEW Follow --}}
        <div class="notif-row bg-white border border-emerald-100 rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
             data-unread="1">
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-emerald-50 text-emerald-600 grid place-items-center">👤</div>
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">Rifky Pratama</b>
                mulai mengikuti Anda.
              </p>
              <div class="mt-1 flex items-center gap-2">
                <span class="text-xs text-slate-400">4j yang lalu</span>
                <span class="badge-unread inline-flex items-center text-[10px] font-semibold bg-emerald-100 text-emerald-700 rounded-full px-2 py-0.5">Baru</span>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <button class="btn-markread text-xs text-emerald-700 hover:underline">Tandai dibaca</button>
              <button class="btn-remove text-xs text-slate-400 hover:text-rose-600">✕</button>
            </div>
          </div>
        </div>

        {{-- 4: READ Challenge --}}
        <div class="notif-row bg-slate-50 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
             data-unread="0">
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-violet-50 text-violet-600 grid place-items-center">✨</div>
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">Admin Eduvoria</b>
                tantangan baru telah dimulai: Tantangan Desain UI.
              </p>
              <span class="text-xs text-slate-400 mt-1 block">1h yang lalu</span>
            </div>
            <button class="btn-remove text-xs text-slate-400 hover:text-rose-600">✕</button>
          </div>
        </div>

        {{-- 5: READ Like --}}
        <div class="notif-row bg-slate-50 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition p-4 sm:p-5"
             data-unread="0">
          <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-full bg-rose-50 text-rose-600 grid place-items-center">❤️</div>
            <div class="flex-1">
              <p class="text-sm">
                <b class="text-slate-900 hover:text-emerald-700 cursor-pointer">Anonim</b>
                menyukai postingan Anda.
              </p>
              <span class="text-xs text-slate-400 mt-1 block">1d yang lalu</span>
            </div>
            <button class="btn-remove text-xs text-slate-400 hover:text-rose-600">✕</button>
          </div>
        </div>
      </div>
    </section>

    {{-- RIGHT: Tips --}}
    <aside class="hidden lg:block space-y-4">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="text-base font-bold text-slate-900 mb-2">Tips Notifikasi</h3>
        <ul class="space-y-2 text-sm text-slate-600 list-disc list-inside">
          <li>Atur preferensi di Pengaturan Akun.</li>
          <li>Notifikasi baru ditandai dengan lencana hijau.</li>
          <li>Tinjau laporan challenge di sini.</li>
        </ul>
      </div>
    </aside>
  </div>
</div>

{{-- JS kecil untuk interaksi UI saja (tanpa backend) --}}
<script>
  const list = document.getElementById('notif-list');
  const tabAll  = document.getElementById('tab-all');
  const tabNew  = document.getElementById('tab-new');
  const tabRead = document.getElementById('tab-read');
  const markAll = document.getElementById('btn-markall') || document.getElementById('btn-markall-sm');

  function setActiveTab(btn) {
    document.querySelectorAll('.tab-btn').forEach(el => {
      el.classList.remove('font-semibold','text-emerald-700','border-b-2','border-emerald-600','pb-px','-mb-px');
      el.classList.add('text-slate-600');
    });
    btn.classList.add('font-semibold','text-emerald-700','border-b-2','border-emerald-600','pb-px','-mb-px');
    btn.classList.remove('text-slate-600');
  }

  tabAll?.addEventListener('click', () => {
    [...list.querySelectorAll('.notif-row')].forEach(r => r.classList.remove('hidden'));
    setActiveTab(tabAll);
  });

  tabNew?.addEventListener('click', () => {
    [...list.querySelectorAll('.notif-row')].forEach(r => r.classList.toggle('hidden', r.dataset.unread !== '1'));
    setActiveTab(tabNew);
  });

  tabRead?.addEventListener('click', () => {
    [...list.querySelectorAll('.notif-row')].forEach(r => r.classList.toggle('hidden', r.dataset.unread !== '0'));
    setActiveTab(tabRead);
  });

  markAll?.addEventListener('click', () => {
    [...list.querySelectorAll('.notif-row')].forEach(r => {
      r.dataset.unread = '0';
      r.classList.remove('bg-white','border-emerald-100');
      r.classList.add('bg-slate-50','border-slate-200');
      r.querySelector('.badge-unread')?.remove();
    });
  });

  list?.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-markread')) {
      const r = e.target.closest('.notif-row');
      r.dataset.unread = '0';
      r.classList.remove('bg-white','border-emerald-100');
      r.classList.add('bg-slate-50','border-slate-200');
      r.querySelector('.badge-unread')?.remove();
    }
    if (e.target.classList.contains('btn-remove')) {
      e.target.closest('.notif-row').remove();
    }
  });
</script>
@endsection
