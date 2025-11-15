@extends('layouts.app')

@section('title', 'Komunitas | Eduvoria')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Jelajahi Komunitas</h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($communities as $community)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 flex flex-col">
                <img src="{{ $community['image'] }}" 
                     class="rounded-xl mb-4 w-full h-40 object-cover" 
                     alt="{{ $community['name'] }}">
                     
                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $community['name'] }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ number_format($community['members']) }} anggota</p>
                <p class="text-sm text-gray-600 flex-grow">{{ $community['description'] }}</p>

                <button class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-sm font-medium transition">
                    Gabung Komunitas
                </button>
            </div>
        @endforeach
    </div>
</div>
@endsection
