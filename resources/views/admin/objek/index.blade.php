@extends('layouts.app')

@section('title', 'Kelola Lapangan')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Lapangan</h1>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">No</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Nama Objek</th>
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
                                <a href="/admin/objek/{{ $o->id_objek }}/edit"
                                    class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada objek.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection