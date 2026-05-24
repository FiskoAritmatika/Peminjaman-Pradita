<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Unit Kegiatan (UKM and other units)
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['UKM Basket']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['UKM Voli']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['UKM Futsal']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['BEM']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['HIMTIKA']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['HIMSI']);
        DB::insert("INSERT INTO unit_kegiatan (nama_unit) VALUES (?)", ['NextSoft']);

        // Users (admin and organisasi per unit)
        // Admin (can manage everything)
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Admin BM', Hash::make('admin123'), 'Admin', null
        ]);
        // UKM Basket user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Budi Basket', Hash::make('organisasi123'), 'Organisasi', 1
        ]);
        // UKM Voli user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Sari Voli', Hash::make('organisasi123'), 'Organisasi', 2
        ]);
        // UKM Futsal user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Rudi Futsal', Hash::make('organisasi123'), 'Organisasi', 3
        ]);
        // BEM user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Budi BEM', Hash::make('organisasi123'), 'Organisasi', 4
        ]);
        // HIMTIKA user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Citra HIMTIKA', Hash::make('organisasi123'), 'Organisasi', 5
        ]);
        // HIMSI user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Dedi HIMSI', Hash::make('organisasi123'), 'Organisasi', 6
        ]);
        // NextSoft (karyawan) user
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Eka NextSoft', Hash::make('karyawan123'), 'Organisasi', 7
        ]);
        // Mahasiswa biasa (can only borrow barang)
        DB::insert("INSERT INTO users (nama_user, password, role, id_unit) VALUES (?, ?, ?, ?)", [
            'Andi Wijaya', Hash::make('mahasiswa123'), 'Mahasiswa', null
        ]);

        // Objek - Lapangan (owned by admin)
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Lapangan Utama', 'lapangan', 1, 1
        ]);

        // Objek - UKM Basket (owned by UKM Basket user)
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Bola Basket', 'barang', 5, 2
        ]);
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Cone', 'barang', 10, 2
        ]);

        // Objek - UKM Voli (owned by UKM Voli user)
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Bola Voli', 'barang', 5, 3
        ]);
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Net Voli', 'barang', 2, 3
        ]);

        // Objek - UKM Futsal (owned by UKM Futsal user)
        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, ?, ?, ?)", [
            'Bola Futsal', 'barang', 5, 4
        ]);

        // Optional: additional objects for other units can be added here
    }
}
