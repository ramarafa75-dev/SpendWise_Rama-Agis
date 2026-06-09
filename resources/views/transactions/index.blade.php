<x-app-layout>
    <x-slot name="header">Riwayat Transaksi</x-slot>

    <div class="max-w-5xl mx-auto py-6 px-4">
        <a href="{{ route('transactions.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
           + Tambah Transaksi
        </a>

        <table class="w-full border mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Kategori</th>
                    <th class="p-3 text-left">Jenis</th>
                    <th class="p-3 text-left">Jumlah (Rp)</th>
                    <th class="p-3 text-left">Jumlah (USD)</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-t">
                    <td class="p-3">{{ $trx->date }}</td>
                    <td class="p-3">{{ $trx->category->name }}</td>
                    <td class="p-3">
                        <span class="{{ $trx->type == 'pemasukan' ? 'text-green-600' : 'text-red-500' }}">
                            {{ ucfirst($trx->type) }}
                        </span>
                    </td>
                    <td class="p-3">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td class="p-3">$ {{ $trx->amount_usd }}</td>
                    <td class="p-3">{{ $trx->description ?? '-' }}</td>
                    <td class="p-3 text-center">
                        <form method="POST" action="{{ route('transactions.destroy', $trx) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>