@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Barang Saya</h1>

    <div class="bg-white rounded shadow p-6 max-w-lg">
        <form method="POST" action="/mahasiswa/barang-saya/{{ $objek->id_objek }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_objek" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_objek" id="nama_objek"
                       value="{{ old('nama_objek', $objek->nama_objek) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah"
                       value="{{ old('jumlah', $objek->jumlah) }}" min="1"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                <a href="/mahasiswa/barang-saya" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
@endsection
