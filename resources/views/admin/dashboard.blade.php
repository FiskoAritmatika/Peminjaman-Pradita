@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin - Building Management</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-sm text-gray-500 mb-1">Pending</h2>
            <p class="text-3xl font-bold text-yellow-600">{{ $totalPending }}</p>
        </div>
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-sm text-gray-500 mb-1">Approved</h2>
            <p class="text-3xl font-bold text-green-600">{{ $totalApproved }}</p>
        </div>
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-sm text-gray-500 mb-1">Rejected</h2>
            <p class="text-3xl font-bold text-red-600">{{ $totalRejected }}</p>
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <a href="/admin/peminjaman" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kelola Peminjaman
        </a>
        <a href="/admin/objek" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            Kelola Lapangan
        </a>
    </div>
@endsection