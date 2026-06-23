<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking PlayStation</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Form Booking</h1>
        
        <div class="bg-blue-50 p-4 rounded-lg mb-6 text-sm text-gray-700">
            <p>Penyewa: <strong class="text-blue-600">{{ auth()->user()->name }}</strong></p>
            <p>Unit PS: <strong>{{ $playstation->nama_unit }}</strong></p>
            <p>Tarif: <strong>Rp {{ number_format($playstation->harga_per_jam, 0, ',', '.') }}/jam</strong></p>
        </div>

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="playstation_id" value="{{ $playstation->id }}">

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Durasi Sewa (Jam):</label>
                <input type="number" name="durasi_jam" min="1" required class="w-full px-3 py-2 border rounded-lg focus:outline-blue-500" placeholder="Contoh: 2">
            </div>

            <div class="flex justify-between items-center">
                <a href="/" class="text-gray-500 hover:underline text-sm">Kembali</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold transition">Konfirmasi Booking</button>
            </div>
        </form>
    </div>

</body>
</html>