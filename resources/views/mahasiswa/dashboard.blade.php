@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Mahasiswa</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if(isset(session('user')['role']) && session('user')['role'] === 'Organisasi')
        {{-- Lapangan Card --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-2">Peminjaman Lapangan</h2>
            <p class="text-gray-500 mb-4">Total peminjaman: <strong>{{ $totalLapangan }}</strong></p>
            <a href="/mahasiswa/lapangan" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Lihat Peminjaman Lapangan
            </a>
        </div>
        @endif

        {{-- Barang Card --}}
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-2">Peminjaman Barang</h2>
            <p class="text-gray-500 mb-4">Total peminjaman: <strong>{{ $totalBarang }}</strong></p>
            <a href="/mahasiswa/barang" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Lihat Peminjaman Barang
            </a>
        </div>
    </div>
@endsection
