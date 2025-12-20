<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Connectify - Login</title>
    </head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    @if ($errors->any())
        <div class="text-red-500 text-sm mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="w-full max-w-md"> 
        <div class="text-center mb-8">
            <div class="text-4xl font-extrabold text-teal-600 mb-2">Eduvoria</div>
            <h1 class="text-2xl font-bold text-gray-800">Masuk Akun</h1>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            placeholder="anda@contoh.com"
                            class="w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-900 focus:border-teal-500 focus:ring-teal-500 shadow-sm sm:text-sm"
                        />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            class="w-full rounded-lg border border-gray-300 py-2 px-3 text-gray-900 focus:border-teal-500 focus:ring-teal-500 shadow-sm sm:text-sm"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                    >
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:text-teal-500">Daftar di sini</a>
        </p>
    </div>

</body>
</html>