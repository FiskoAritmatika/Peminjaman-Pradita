@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Barang')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Ajukan Peminjaman Barang</h1>

    <div class="bg-white rounded shadow p-6 max-w-lg">
        <form method="POST" action="/mahasiswa/barang">
            @csrf

            <div class="mb-4">
                <label for="id_objek" class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang</label>
                <select name="id_objek" id="id_objek" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id_objek }}" {{ old('id_objek') == $b->id_objek ? 'selected' : '' }}>
                            {{ $b->nama_objek }} (Tersedia: {{ $b->jumlah }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah_pinjam" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pinjam</label>
                <input type="number" name="jumlah_pinjam" id="jumlah_pinjam" value="{{ old('jumlah_pinjam', 1) }}" min="1"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan</label>
                <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}"
                       placeholder="Contoh: Latihan Basket"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajukan</button>
                <a href="/mahasiswa/barang" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
@endsection
