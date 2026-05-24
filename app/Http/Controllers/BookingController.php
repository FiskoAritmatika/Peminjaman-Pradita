<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function dashboard()
    {
        $user = (object) session('user');

        $totalLapangan = DB::select("
            SELECT COUNT(*) as total FROM detail_peminjaman dp
            JOIN peminjaman p ON dp.id_peminjaman = p.id_peminjaman
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE p.id_user = ? AND o.jenis_objek = 'lapangan'
        ", [$user->id_user])[0]->total;

        $totalBarang = DB::select("
            SELECT COUNT(*) as total FROM detail_peminjaman dp
            JOIN peminjaman p ON dp.id_peminjaman = p.id_peminjaman
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE p.id_user = ? AND o.jenis_objek = 'barang'
        ", [$user->id_user])[0]->total;

        return view('mahasiswa.dashboard', compact('totalLapangan', 'totalBarang'));
    }

    // ========== LAPANGAN ==========

    public function indexLapangan()
    {
        $user = (object) session('user');
        $peminjaman = collect(DB::select(
            "SELECT p.tanggal_pengajuan as tanggal, dp.id_detail as id_peminjaman, dp.status, dp.tipe_pinjam, dp.tanggal_mulai, dp.tanggal_selesai, dp.jam_mulai, dp.jam_selesai, dp.jumlah_pinjam, o.nama_objek, p.kegiatan
             FROM peminjaman p
             JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
             JOIN objek o ON dp.id_objek = o.id_objek
             WHERE p.id_user = ? AND o.jenis_objek = 'lapangan'
             ORDER BY dp.created_at DESC, dp.id_detail DESC",
            [$user->id_user]
        ));

        return view('mahasiswa.lapangan.index', compact('peminjaman'));
    }

    public function createLapangan()
    {
        $lapangan = DB::select("SELECT * FROM objek WHERE jenis_objek = 'lapangan'");
        return view('mahasiswa.lapangan.create', compact('lapangan'));
    }

    public function storeLapangan(Request $request)
    {
        $request->validate([
            'id_objek' => 'required',
            'tipe_pinjam' => 'required|in:per_jam,per_hari',
            'tanggal_mulai' => 'required|date|after_or_equal:today|before_or_equal:+1 month',
            'kegiatan' => 'required|string',
        ]);

        if ($request->tipe_pinjam === 'per_jam') {
            $request->validate([
                'jam_mulai' => 'required',
                'jam_selesai' => 'required|after:jam_mulai',
            ]);
            $tanggal_selesai = $request->tanggal_mulai;
            $jam_mulai = $request->jam_mulai;
            $jam_selesai = $request->jam_selesai;
        } else {
            $request->validate([
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai|before_or_equal:+1 month',
            ]);
            $tanggal_selesai = $request->tanggal_selesai;
            $jam_mulai = null;
            $jam_selesai = null;
        }

        $user = (object) session('user');

        $clash = DB::select(
            "SELECT dp.id_detail
            FROM detail_peminjaman dp
            WHERE dp.id_objek = ?
              AND dp.status IN ('pending', 'approved')
              AND (
                  (dp.tipe_pinjam = 'per_hari' AND dp.tanggal_mulai <= ? AND dp.tanggal_selesai >= ?)
                  OR
                  (dp.tipe_pinjam = 'per_jam' AND dp.tanggal_mulai <= ? AND dp.tanggal_selesai >= ?
                       AND dp.jam_mulai < ? AND dp.jam_selesai > ?)
              )",
            [
                $request->id_objek,
                // dates for per_hari overlap check
                $tanggal_selesai,
                $request->tanggal_mulai,
                // dates for per_jam overlap check
                $tanggal_selesai,
                $request->tanggal_mulai,
                $jam_selesai,
                $jam_mulai
            ]
        );

        if (count($clash) > 0) {
            return back()->with('error', 'Jadwal bentrok dengan peminjaman lain!')->withInput();
        }

        DB::insert("INSERT INTO peminjaman (id_user, tanggal_pengajuan, kegiatan) VALUES (?, ?, ?)", [
            $user->id_user,
            date('Y-m-d H:i:s'),
            $request->kegiatan
        ]);

        $idPeminjaman = DB::getPdo()->lastInsertId();

        DB::insert("INSERT INTO detail_peminjaman (id_peminjaman, id_objek, jumlah_pinjam, tipe_pinjam, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $idPeminjaman,
            $request->id_objek,
            1,
            $request->tipe_pinjam,
            $request->tanggal_mulai,
            $tanggal_selesai,
            $jam_mulai,
            $jam_selesai,
            'pending'
        ]);

        return redirect('/mahasiswa/lapangan')->with('success', 'Peminjaman lapangan berhasil diajukan!');
    }

    public function cancelLapangan($id)
    {
        $user = (object) session('user');
        DB::update("UPDATE detail_peminjaman SET status = 'rejected' WHERE id_detail = ? AND status = 'pending' AND id_peminjaman IN (SELECT id_peminjaman FROM peminjaman WHERE id_user = ?)", [
            $id,
            $user->id_user
        ]);
        return redirect('/mahasiswa/lapangan')->with('success', 'Peminjaman dibatalkan.');
    }

    // ========== BARANG ==========

    public function indexBarang()
    {
        $user = (object) session('user');
        $peminjaman = DB::select(
            "SELECT p.tanggal_pengajuan as tanggal, dp.id_detail as id_peminjaman, dp.status, dp.tipe_pinjam, dp.tanggal_mulai, dp.tanggal_selesai, dp.jam_mulai, dp.jam_selesai, dp.jumlah_pinjam, o.nama_objek, p.kegiatan
            FROM peminjaman p
            JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE p.id_user = ? AND o.jenis_objek = 'barang'
            ORDER BY dp.created_at DESC, dp.id_detail DESC",
            [$user->id_user]
        );

        return view('mahasiswa.barang.index', compact('peminjaman'));
    }

    public function createBarang()
    {
        $user = (object) session('user');
        $barang = DB::select("SELECT * FROM objek WHERE jenis_objek = 'barang' AND id_user != ?", [$user->id_user]);
        return view('mahasiswa.barang.create', compact('barang'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'id_objek' => 'required',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date|after_or_equal:today|before_or_equal:+1 month',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai|before_or_equal:+1 month',
            'kegiatan' => 'required|string',
        ]);

        $user = (object) session('user');

        // Check available stock for the requested barang
        $objek = DB::select(
            "SELECT jumlah FROM objek WHERE id_objek = ? AND jenis_objek = 'barang'",
            [$request->id_objek]
        );

        if (empty($objek) || $request->jumlah_pinjam > $objek[0]->jumlah) {
            return back()
                ->with('error', 'Stok barang tidak mencukupi!')
                ->withInput();
        }

        DB::insert("INSERT INTO peminjaman (id_user, tanggal_pengajuan, kegiatan) VALUES (?, ?, ?)", [
            $user->id_user,
            date('Y-m-d H:i:s'),
            $request->kegiatan
        ]);

        $idPeminjaman = DB::getPdo()->lastInsertId();

        DB::insert("INSERT INTO detail_peminjaman (id_peminjaman, id_objek, jumlah_pinjam, tipe_pinjam, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $idPeminjaman,
            $request->id_objek,
            $request->jumlah_pinjam,
            'per_hari',
            $request->tanggal_mulai,
            $request->tanggal_selesai,
            null,
            null,
            'pending'
        ]);

        return redirect('/mahasiswa/barang')->with('success', 'Peminjaman barang berhasil diajukan!');
    }

    public function cancelBarang($id)
    {
        $user = (object) session('user');
        DB::update("UPDATE detail_peminjaman SET status = 'rejected' WHERE id_detail = ? AND status = 'pending' AND id_peminjaman IN (SELECT id_peminjaman FROM peminjaman WHERE id_user = ?)", [
            $id,
            $user->id_user
        ]);
        return redirect('/mahasiswa/barang')->with('success', 'Peminjaman dibatalkan.');
    }

    // ========== KELOLA BARANG SAYA ==========

    public function barangSayaIndex()
    {
        $user = (object) session('user');
        $objek = DB::select("SELECT * FROM objek WHERE jenis_objek = 'barang' AND id_user = ? ORDER BY nama_objek", [$user->id_user]);
        return view('mahasiswa.barang_saya.index', compact('objek'));
    }

    public function barangSayaCreate()
    {
        return view('mahasiswa.barang_saya.create');
    }

    public function barangSayaStore(Request $request)
    {
        $request->validate([
            'nama_objek' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = (object) session('user');

        DB::insert("INSERT INTO objek (nama_objek, jenis_objek, jumlah, id_user) VALUES (?, 'barang', ?, ?)", [
            $request->nama_objek,
            $request->jumlah,
            $user->id_user
        ]);

        return redirect('/mahasiswa/barang-saya')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function barangSayaEdit($id)
    {
        $user = (object) session('user');
        $objek = DB::select("SELECT * FROM objek WHERE id_objek = ? AND id_user = ?", [$id, $user->id_user]);

        if (empty($objek)) {
            abort(404);
        }

        return view('mahasiswa.barang_saya.edit', ['objek' => $objek[0]]);
    }

    public function barangSayaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_objek' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);
        $user = (object) session('user');

        DB::update("UPDATE objek SET nama_objek = ?, jumlah = ? WHERE id_objek = ? AND id_user = ?", [
            $request->nama_objek,
            $request->jumlah,
            $id,
            $user->id_user
        ]);

        return redirect('/mahasiswa/barang-saya')->with('success', 'Barang berhasil diperbarui!');
    }

    public function barangSayaDelete($id)
    {
        $user = (object) session('user');
        DB::delete("DELETE FROM detail_peminjaman WHERE id_objek = ? AND id_objek IN (SELECT id_objek FROM objek WHERE id_user = ?)", [$id, $user->id_user]);
        DB::delete("DELETE FROM peminjaman WHERE id_peminjaman NOT IN (SELECT id_peminjaman FROM detail_peminjaman)");
        DB::delete("DELETE FROM objek WHERE id_objek = ? AND id_user = ?", [$id, $user->id_user]);

        return redirect('/mahasiswa/barang-saya')->with('success', 'Barang berhasil dihapus!');
    }

    // ========== PERMINTAAN MASUK ==========

    public function permintaanMasukIndex()
    {
        $user = (object) session('user');
        $peminjaman = DB::select("
            SELECT p.tanggal_pengajuan as tanggal, dp.id_detail as id_peminjaman, dp.status, dp.tipe_pinjam, dp.tanggal_mulai, dp.tanggal_selesai, dp.jumlah_pinjam, u.nama_user as peminjam, o.nama_objek, p.kegiatan
            FROM peminjaman p
            JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
            JOIN users u ON p.id_user = u.id_user
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE o.id_user = ? AND o.jenis_objek = 'barang'
            ORDER BY p.tanggal_pengajuan DESC, dp.id_detail DESC
        ", [$user->id_user]);

        return view('mahasiswa.permintaan_masuk.index', compact('peminjaman'));
    }

    public function permintaanMasukApprove($id)
    {
        $user = (object) session('user');

        // Ambil data peminjaman beserta stok objeknya
        $requests = DB::select("
            SELECT dp.*, o.jumlah, o.id_objek
            FROM detail_peminjaman dp
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE dp.id_detail = ? AND o.id_user = ? AND dp.status = 'pending'
        ", [$id, $user->id_user]);

        if (empty($requests)) {
            return redirect('/mahasiswa/permintaan-masuk')->with('error', 'Permintaan tidak ditemukan atau sudah diproses.');
        }

        $requestItem = $requests[0];

        if ($requestItem->jumlah < $requestItem->jumlah_pinjam) {
            return redirect('/mahasiswa/permintaan-masuk')->with('error', 'Stok barang tidak mencukupi untuk disetujui!');
        }

        // Set status peminjaman menjadi approved
        DB::update("UPDATE detail_peminjaman SET status = 'approved' WHERE id_detail = ?", [$id]);

        // Kurangi stok barang
        DB::update("UPDATE objek SET jumlah = jumlah - ? WHERE id_objek = ?", [$requestItem->jumlah_pinjam, $requestItem->id_objek]);

        return redirect('/mahasiswa/permintaan-masuk')->with('success', 'Peminjaman disetujui!');
    }

    public function permintaanMasukReject($id)
    {
        $user = (object) session('user');
        DB::update("
            UPDATE detail_peminjaman dp
            JOIN objek o ON dp.id_objek = o.id_objek
            SET dp.status = 'rejected' 
            WHERE dp.id_detail = ? AND o.id_user = ?
        ", [$id, $user->id_user]);
        return redirect('/mahasiswa/permintaan-masuk')->with('success', 'Peminjaman ditolak.');
    }

    public function permintaanMasukReturn($id)
    {
        $user = (object) session('user');

        $requests = DB::select("
            SELECT dp.*, o.id_objek
            FROM detail_peminjaman dp
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE dp.id_detail = ? AND o.id_user = ? AND dp.status = 'approved'
        ", [$id, $user->id_user]);

        if (empty($requests)) {
            return redirect('/mahasiswa/permintaan-masuk')->with('error', 'Data tidak valid atau peminjaman belum disetujui.');
        }

        $requestItem = $requests[0];

        // Set status ke returned
        DB::update("UPDATE detail_peminjaman SET status = 'returned' WHERE id_detail = ?", [$id]);

        // Kembalikan stok
        DB::update("UPDATE objek SET jumlah = jumlah + ? WHERE id_objek = ?", [$requestItem->jumlah_pinjam, $requestItem->id_objek]);

        return redirect('/mahasiswa/permintaan-masuk')->with('success', 'Barang berhasil dikembalikan dan stok bertambah!');
    }
}
