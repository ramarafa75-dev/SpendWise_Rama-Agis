<x-app-layout>
    <x-slot name="header">Kategori Anggaran</x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">

        {{-- Form Tambah Kategori --}}
        <form method="POST" action="{{ route('categories.store') }}" class="mb-6">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="name" placeholder="Nama Kategori (Makanan, Kost...)"
                    class="border rounded px-3 py-2 flex-1" required>
                <input type="number" name="max_budget" placeholder="Maks. Budget (Rp)"
                    class="border rounded px-3 py-2 w-48" required>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
            </div>
        </form>

        {{-- List Kategori --}}
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Maks. Budget</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr class="border-t">
                    <td class="p-3">{{ $cat->name }}</td>
                    <td class="p-3">Rp {{ number_format($cat->max_budget, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <form method="POST" action="{{ route('categories.destroy', $cat) }}">
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