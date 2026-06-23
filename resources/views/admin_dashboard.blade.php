<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Rental PS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 p-6 md:p-12 text-slate-200">

    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Panel Kendali Admin</h1>
                <p class="text-slate-400">Kelola unit dan pantau penyewa PlayStation Anda</p>
            </div>
            <a href="{{ route('rental.index') }}" class="bg-slate-800 border border-slate-700 text-white px-5 py-2.5 rounded-lg hover:bg-slate-700 transition">
                ← Kembali ke Rental
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-slate-900 p-6 rounded-xl shadow-lg border border-slate-800 h-fit">
                <h2 class="text-xl font-bold text-white mb-4">➕ Tambah Unit PS Baru</h2>
                <form action="{{ route('admin.playstation.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-slate-400 text-sm font-semibold mb-2">Nama Unit:</label>
                        <input type="text" name="nama_unit" required class="w-full px-3 py-2 border rounded-lg bg-slate-800 border-slate-700 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    </div>
                    <div class="mb-4">
                        <label class="block text-slate-400 text-sm font-semibold mb-2">Jenis PlayStation:</label>
                        <select name="jenis" required class="w-full px-3 py-2 border rounded-lg bg-slate-800 border-slate-700 text-white focus:ring-2 focus:ring-red-600 outline-none">
                            <option value="PS3">PlayStation 3</option>
                            <option value="PS4">PlayStation 4</option>
                            <option value="PS5">PlayStation 5</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-slate-400 text-sm font-semibold mb-2">Harga per Jam (Rp):</label>
                        <input type="number" name="harga_per_jam" required class="w-full px-3 py-2 border rounded-lg bg-slate-800 border-slate-700 text-white focus:ring-2 focus:ring-red-600 outline-none">
                    </div>
                    <button type="submit" class="w-full bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 font-bold transition">Simpan</button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-slate-900 rounded-xl shadow-lg border border-slate-800 overflow-hidden">
                <div class="p-6 bg-slate-800/50 border-b border-slate-700">
                    <h2 class="text-xl font-bold text-white">📋 Daftar Penyewa & Transaksi</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
    <thead class="text-slate-400 text-xs uppercase bg-slate-950">
        <tr>
            <th class="p-4">No</th>
            <th class="p-4">Nama Penyewa</th>
            <th class="p-4">Unit PS</th>
            <th class="p-4">Durasi</th> <th class="p-4">Total</th>   <th class="p-4 text-center">Aksi</th> </tr>
    </thead>

    <tbody class="divide-y divide-slate-800">
        @forelse($bookings as $index => $booking)
        <tr class="hover:bg-slate-800/50">
            <td class="p-4 text-slate-500">{{ $index + 1 }}</td>
            <td class="p-4 font-bold text-red-400">{{ $booking->user->name ?? 'User Tidak Ditemukan' }}</td>
            <td class="p-4 font-semibold text-white">{{ $booking->playstation->nama_unit ?? 'Unit Dihapus' }}</td>
            <td class="p-4 text-slate-300">{{ $booking->durasi ?? '0' }} Jam</td> <td class="p-4 font-bold text-emerald-400">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td> <td class="p-4 flex gap-2 justify-center">
                <form action="{{ route('admin.booking.selesai', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-emerald-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-emerald-700">SELESAI</button>
                </form>
                <button onclick="openEditModal('{{ $booking->playstation_id }}', '{{ $booking->playstation->nama_unit ?? '' }}', '{{ $booking->playstation->harga_per_jam ?? '' }}')" 
                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700">EDIT</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="p-10 text-center text-slate-500 italic">Belum ada penyewa.</td>
        </tr>
        @endforelse
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>
    
    <div id="editModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-slate-900 border border-slate-700 p-6 rounded-2xl w-full max-w-sm shadow-2xl">
            <h2 class="text-lg font-bold text-white mb-4">Edit Data Unit</h2>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <label class="text-xs font-bold text-slate-400 uppercase">Nama Unit</label>
                <input type="text" name="nama_unit" id="edit_nama" class="w-full mb-3 p-2 bg-slate-800 border border-slate-700 text-white rounded-lg" required>
                <label class="text-xs font-bold text-slate-400 uppercase">Harga (Rp)</label>
                <input type="number" name="harga_per_jam" id="edit_harga" class="w-full mb-4 p-2 bg-slate-800 border border-slate-700 text-white rounded-lg" required>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded-lg font-bold hover:bg-red-700">Simpan</button>
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="bg-slate-700 text-white px-4 py-2 rounded-lg font-bold">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nama, harga) {
            document.getElementById('editForm').action = "/admin/playstation/" + id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</body>
</html>