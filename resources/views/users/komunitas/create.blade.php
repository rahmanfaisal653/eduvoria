@extends('layouts.app')

@section('title', 'Buat Diskusi Baru')

@section('content')
<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-3xl font-bold text-slate-800 mb-6">Buat Diskusi Baru</h1>

  <form id="create-discussion-form" class="bg-white p-6 rounded-2xl shadow space-y-4" novalidate>
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Diskusi</label>
      <input type="text" name="title" required
             class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500"
             placeholder="Masukkan judul diskusi…">
    </div>

    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Diskusi</label>
      <textarea name="content" rows="5" required
                class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-emerald-500 focus:ring-emerald-500"
                placeholder="Tulis pertanyaan atau topik yang ingin didiskusikan…"></textarea>
    </div>

    <div class="flex items-center gap-3">
      <button type="button" id="save-discussion-btn"
              class="px-5 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
        Simpan
      </button>
      <a href="{{ route('komunitas') }}"
         class="text-slate-600 hover:text-slate-800 text-sm font-medium">
         Batal
      </a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('create-discussion-form');
  const btn  = document.getElementById('save-discussion-btn');

  btn?.addEventListener('click', () => {
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    form.reset();

    // popup kecil sebentar (opsional)
    const popup = document.createElement('div');
    popup.textContent = '✅ Berhasil membuat diskusi!';
    popup.className = 'fixed top-8 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white px-5 py-2 rounded-lg shadow-lg z-50 animate-fadein';
    document.body.appendChild(popup);

    // redirect CEPAT (0.5s) + kirim penanda via hash
    setTimeout(() => {
      window.location.href = "{{ route('komunitas') }}#created";
    }, 500);
  });
});
</script>

<style>
@keyframes fadein {
  from { opacity: 0; transform: translate(-50%, -10px); }
  to   { opacity: 1; transform: translate(-50%, 0); }
}
.animate-fadein { animation: fadein .25s ease-out; }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  if (location.hash === '#created') {
    // bersihin hash supaya ga muncul lagi saat reload
    history.replaceState(null, '', location.pathname + location.search);

    const toast = document.createElement('div');
    toast.textContent = '✅ Diskusi berhasil dibuat';
    toast.className = 'fixed top-8 left-1/2 -translate-x-1/2 bg-emerald-600 text-white px-5 py-2 rounded-lg shadow-lg z-50 animate-fadein';
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.transition = 'opacity .3s';
      toast.style.opacity = '0';
      setTimeout(() => toast.remove(), 300);
    }, 1500);
  }
});
</script>
<style>
@keyframes fadein { from {opacity:0; transform: translate(-50%,-10px);} to {opacity:1; transform: translate(-50%,0);} }
.animate-fadein { animation: fadein .25s ease-out; }
</style>
@endpush
