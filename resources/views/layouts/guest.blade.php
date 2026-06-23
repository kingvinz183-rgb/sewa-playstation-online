<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sewa PlayStation Online</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col justify-center items-center p-4 bg-[#050505]" 
          style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)), url('{{ asset('images/KgCxFr.webp') }}'); background-size: cover; background-position: center;">
        
        <div class="text-center mb-8">
            <span class="text-4xl">🎮</span>
            <h1 class="text-2xl font-black text-white tracking-wider mt-2">
                PS-RENTAL <span class="text-red-600">APP</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1 font-semibold">Sewa PlayStation Cepat, Mudah, & Online</p>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 bg-slate-900/90 backdrop-blur-md border border-slate-700 shadow-[0_25px_60px_rgba(0,0,0,0.8)] rounded-3xl">
            {{ $slot }}
        </div>

    </body>
</html>