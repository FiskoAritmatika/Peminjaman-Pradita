@extends('layouts.app')

@section('title', 'Barang Saya')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Barang Saya</h1>
        <a href="/mahasiswa/barang-saya/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Barang
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">No</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Nama Barang</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($objek as $i => $o)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $o->nama_objek }}</td>
                        <td class="px-4 py-3">{{ $o->jumlah }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="/mahasiswa/barang-saya/{{ $o->id_objek }}/edit"
                                   class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                <form action="/mahasiswa/barang-saya/{{ $o->id_objek }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Anda belum mendaftarkan barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
