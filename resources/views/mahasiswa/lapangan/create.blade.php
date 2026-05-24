@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Lapangan')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Ajukan Peminjaman Lapangan</h1>

    <div class="bg-white rounded shadow p-6 max-w-lg">
        <form method="POST" action="/mahasiswa/lapangan">
            @csrf

            <div class="mb-4">
                <label for="id_objek" class="block text-sm font-medium text-gray-700 mb-1">Pilih Lapangan</label>
                <select name="id_objek" id="id_objek" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Pilih --</option>
                    @foreach($lapangan as $l)
                        <option value="{{ $l->id_objek }}" {{ old('id_objek') == $l->id_objek ? 'selected' : '' }}>
                            {{ $l->nama_objek }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="tipe_pinjam" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pinjam</label>
                <select name="tipe_pinjam" id="tipe_pinjam" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="per_jam" {{ old('tipe_pinjam') == 'per_jam' ? 'selected' : '' }}>Per Jam</option>
                    <option value="per_hari" {{ old('tipe_pinjam') == 'per_hari' ? 'selected' : '' }}>Per Hari</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal_mulai" id="label_tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div id="wrapper_tanggal_selesai" class="hidden">
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4" id="wrapper_jam">
                <div>
                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                    <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tipePinjam = document.getElementById('tipe_pinjam');
                    const wrapperJam = document.getElementById('wrapper_jam');
                    const wrapperTanggalSelesai = document.getElementById('wrapper_tanggal_selesai');
                    const labelTanggalMulai = document.getElementById('label_tanggal_mulai');
                    const jamMulai = document.getElementById('jam_mulai');
                    const jamSelesai = document.getElementById('jam_selesai');
                    const tanggalSelesai = document.getElementById('tanggal_selesai');

                    function toggleFields() {
                        if (tipePinjam.value === 'per_jam') {
                            wrapperJam.classList.remove('hidden');
                            wrapperTanggalSelesai.classList.add('hidden');
                            labelTanggalMulai.textContent = 'Tanggal';
                            jamMulai.required = true;
                            jamSelesai.required = true;
                            tanggalSelesai.required = false;
                        } else {
                            wrapperJam.classList.add('hidden');
                            wrapperTanggalSelesai.classList.remove('hidden');
                            labelTanggalMulai.textContent = 'Tanggal Mulai';
                            jamMulai.required = false;
                            jamSelesai.required = false;
                            tanggalSelesai.required = true;
                        }
                    }

                        // Attach change listener to the correct select element
                        tipePinjam.addEventListener('change', toggleFields);
                        toggleFields(); // initial run based on current selection
                });
            </script>

            <div class="mb-6">
                <label for="kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan</label>
                <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}"
                       placeholder="Contoh: Latihan Futsal UKM"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajukan</button>
                <a href="/mahasiswa/lapangan" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
@endsection
