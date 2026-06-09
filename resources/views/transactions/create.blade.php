<x-app-layout>
    <x-slot name="header">Tambah Transaksi</x-slot>

    <div class="max-w-xl mx-auto py-6 px-4">
        <form method="POST" action="{{ route('transactions.store') }}" class="space-y-4">
            @csrf

            <div>
                <label>Kategori</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Jenis</label>
                <select name="type" class="w-full border rounded px-3 py-2">
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>

            <div>
                <label>Jumlah (Rp)</label>
                <input type="number" name="amount" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Deskripsi</label>
                <input type="text" name="description" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label>Tanggal</label>
                <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded">Simpan Transaksi</button>
        </form>
    </div>
</x-app-layout>