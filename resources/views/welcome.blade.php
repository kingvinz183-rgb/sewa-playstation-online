<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PS-RENTAL APP | Rental PlayStation Online</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Efek latar belakang gelap ala Miles Morales */
        body { 
            background-color: #0f172a; 
            background-image: radial-gradient(circle at 20% 30%, rgba(220, 38, 38, 0.15), transparent 40%),
                              radial-gradient(circle at 80% 70%, rgba(30, 41, 59, 0.5), transparent 40%);
            font-family: 'Segoe UI', sans-serif; 
        }
    </style>
</head>
<body class="p-4 md:p-8 text-slate-100">

    <div class="max-w-4xl mx-auto mb-8 bg-slate-900/80 backdrop-blur-md p-4 rounded-2xl shadow-2xl flex justify-between items-center border border-slate-700">
        <span class="font-black text-white flex items-center gap-2 tracking-tighter">🎮 PS-RENTAL APP</span>
        <div class="flex gap-4 items-center">
            @auth
                <span class="text-sm text-slate-300 hidden sm:inline">Halo, <strong class="text-red-500">{{ auth()->user()->name }}</strong></span>
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm bg-slate-700 text-white px-4 py-2 rounded-lg hover:bg-slate-600 font-bold transition">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 font-bold">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 font-bold transition shadow-lg shadow-red-900/50">Login</a>
            @endauth
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-black text-center mb-10 text-white tracking-tight">Daftar Rental PlayStation</h1>
        
        @if(session('success'))
            <div class="bg-red-600 text-white px-4 py-3 rounded-xl mb-8 text-center font-bold shadow-lg shadow-red-900/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($playstations as $ps)
                <div class="bg-slate-900/60 backdrop-blur-sm p-6 rounded-3xl shadow-xl border border-slate-700 hover:border-red-500/50 transition-all duration-300 hover:scale-[1.02]">
                    <h2 class="text-xl font-bold text-white">{{ $ps->nama_unit }}</h2>
                    <p class="text-slate-400 text-sm mb-4">Konsol: <span class="text-white font-semibold">{{ $ps->jenis }}</span></p>
                    <p class="text-2xl font-black text-red-500">Rp {{ number_format($ps->harga_per_jam, 0, ',', '.') }} <span class="text-sm font-medium text-slate-500">/ jam</span></p>
                    
                    <div class="mt-6 flex justify-between items-center">
                        <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $ps->status == 'tersedia' ? 'bg-green-900/50 text-green-400 border border-green-800' : 'bg-red-900/50 text-red-400 border border-red-800' }}">
                            {{ ucfirst($ps->status) }}
                        </span>
                        
                        @if($ps->status == 'tersedia')
                            @auth
                                <button onclick="openBookingModal('{{ $ps->id }}', '{{ $ps->nama_unit }}', '{{ $ps->harga_per_jam }}')" class="bg-red-600 text-white px-5 py-2 rounded-xl hover:bg-red-700 text-sm font-black transition">
                                    BOOKING
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="bg-slate-700 text-white px-5 py-2 rounded-xl hover:bg-slate-600 text-sm font-bold">Login Dulu</a>
                            @endauth
                        @else
                            <button class="bg-slate-800 text-slate-500 px-5 py-2 rounded-xl text-sm font-bold cursor-not-allowed" disabled>TERPAKAI</button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 col-span-2 py-10">Belum ada unit tersedia.</p>
            @endforelse
        </div>
    </div>

    <div id="bookingModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl max-w-sm w-full p-8 shadow-2xl">
            <h3 class="text-xl font-black text-white mb-1">Konfirmasi</h3>
            <p id="modalPsName" class="text-sm font-bold text-red-500 mb-6"></p>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="playstation_id" id="modalPsId">

                <div class="mb-5">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Durasi (Jam):</label>
                    <input type="number" name="durasi" id="modalDurasi" min="1" value="1" oninput="hitungTotal()" class="w-full px-4 py-3 bg-slate-800 rounded-xl font-bold text-white border-0 focus:ring-2 focus:ring-red-500" required>
                </div>

                <div class="bg-black/40 p-4 rounded-2xl mb-8 flex justify-between items-center border border-slate-700">
                    <span class="text-xs font-bold text-slate-400 uppercase">Total Bayar:</span>
                    <span id="modalTotalHarga" class="font-black text-white text-xl">Rp 0</span>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-4 bg-red-600 text-white rounded-xl font-black text-sm hover:bg-red-700 transition shadow-lg shadow-red-900/50">KONFIRMASI SEWA</button>
                    <button type="button" onclick="closeBookingModal()" class="w-full py-2 text-slate-500 text-xs font-bold hover:text-slate-300">BATAL</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let hargaPerJam = 0;
        function openBookingModal(id, name, harga) {
            hargaPerJam = parseInt(harga);
            document.getElementById('modalPsId').value = id;
            document.getElementById('modalPsName').innerText = name;
            document.getElementById('modalDurasi').value = 1;
            document.getElementById('bookingModal').classList.remove('hidden');
            hitungTotal();
        }
        function closeBookingModal() { document.getElementById('bookingModal').classList.add('hidden'); }
        function hitungTotal() {
            let durasi = document.getElementById('modalDurasi').value || 0;
            let total = hargaPerJam * parseInt(durasi);
            document.getElementById('modalTotalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>