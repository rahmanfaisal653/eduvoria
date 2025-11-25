<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Eduvoria')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex">


    <aside class="w-64 bg-gray-800 text-white flex-shrink-0 flex flex-col">
        <div class="p-4 text-3xl font-extrabold text-teal-400 border-b border-gray-700">
            Eduvoria Admin
        </div>
        <nav class="flex-grow p-4 space-y-2">
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.dashboard')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">

            <!-- Kelas aktif akan dikontrol di view yang meng-extend (misalnya: 'bg-teal-600 font-semibold shadow-md') -->
            <!-- <a href="" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.dashboard')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">

                <span class="mr-3">🏠</span> Dashboard
            </a> -->
            <a href="{{ route('admin.users') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.users')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">
                <span class="mr-3">👥</span> Manajemen Pengguna
            </a>
            <a href="{{ route('admin.content') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.content')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">
                <span class="mr-3">📝</span> Konten & Postingan
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.reports')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">
                <span class="mr-3">🚨</span> Laporan & Pelanggaran
            </a>
          
            <a href="{{ route('admin.subscribe') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.subscribe')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">
                <span class="mr-3">💲</span> Laporan Subscribe
            </a>


            <a href="{{ route('admin.komunitas.index') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.komunitas.*'))  bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">
                <span class="mr-3">👥</span> Kelola Komunitas
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.settings')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">

            <!-- <a href="" class="flex items-center p-3 rounded-lg @if(request()->routeIs('admin.settings')) bg-teal-600 font-semibold shadow-md @else text-gray-300 hover:bg-gray-700 @endif">

                <span class="mr-3">⚙️</span> Pengaturan Sistem
            </a> -->
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="" class="flex items-center text-red-400 hover:text-red-500">
                <span class="mr-2">🚪</span> Logout
            </a>
        </div>
    </aside>

   
    <div class="flex-grow p-8">
        
        
        <header class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">@yield('page_title', 'Dashboard Admin')</h1>
            <div class="flex items-center space-x-3">
               
                <span class="text-sm text-gray-600">Admin: {{ Auth::user()->name ?? 'Pengguna Admin' }}</span> 
                <div class="h-8 w-8 rounded-full bg-orange-400"></div>
            </div>
        </header>

       
        @yield('content')

    </div>

    @stack('scripts')
</body>
</html>
