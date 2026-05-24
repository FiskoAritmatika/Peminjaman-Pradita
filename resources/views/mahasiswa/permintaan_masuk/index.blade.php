@extends('layouts.app')

@section('title', 'Permintaan Barang Masuk')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Permintaan Barang Masuk</h1>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">No</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Peminjam</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Barang</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Tanggal Mulai</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Tanggal Selesai</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Kegiatan</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Status</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $i => $p)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $p->peminjam }}</td>
                        <td class="px-4 py-3">{{ $p->nama_objek }}</td>
                        <td class="px-4 py-3">{{ $p->jumlah_pinjam }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_mulai }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_selesai }}</td>
                        <td class="px-4 py-3">{{ $p->kegiatan }}</td>
                        <td class="px-4 py-3">
                            @if($p->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Pending</span>
                            @elseif($p->status === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Approved</span>
                            @elseif($p->status === 'returned')
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Selesai/Kembali</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($p->status === 'pending')
                                <div class="flex gap-2">
                                    <form action="/mahasiswa/permintaan-masuk/{{ $p->id_peminjaman }}/approve" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="/mahasiswa/permintaan-masuk/{{ $p->id_peminjaman }}/reject" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-600 text-white text-xs px-3 py-1 rounded hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @elseif($p->status === 'approved')
                                <form action="/mahasiswa/permintaan-masuk/{{ $p->id_peminjaman }}/return" method="POST"
                                      onsubmit="return confirm('Tandai barang telah dikembalikan?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">
                                        Tandai Dikembalikan
                                    </button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">Belum ada permintaan barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
