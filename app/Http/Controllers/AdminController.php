<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPending = DB::select("SELECT COUNT(*) as total FROM detail_peminjaman dp JOIN objek o ON dp.id_objek = o.id_objek WHERE dp.status = 'pending' AND o.jenis_objek = 'lapangan'")[0]->total;
        $totalApproved = DB::select("SELECT COUNT(*) as total FROM detail_peminjaman dp JOIN objek o ON dp.id_objek = o.id_objek WHERE dp.status = 'approved' AND o.jenis_objek = 'lapangan'")[0]->total;
        $totalRejected = DB::select("SELECT COUNT(*) as total FROM detail_peminjaman dp JOIN objek o ON dp.id_objek = o.id_objek WHERE dp.status = 'rejected' AND o.jenis_objek = 'lapangan'")[0]->total;

        return view('admin.dashboard', compact('totalPending', 'totalApproved', 'totalRejected'));
    }

    // ========== PEMINJAMAN MANAGEMENT ==========

    public function peminjamanIndex()
    {
        $peminjaman = DB::select("
            SELECT p.tanggal_pengajuan, dp.id_detail as id_peminjaman, dp.status, dp.tipe_pinjam, dp.tanggal_mulai, dp.tanggal_selesai, dp.jam_mulai, dp.jam_selesai, dp.jumlah_pinjam, u.nama_user, o.nama_objek, o.jenis_objek, p.kegiatan
            FROM peminjaman p
            JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
            JOIN users u ON p.id_user = u.id_user
            JOIN objek o ON dp.id_objek = o.id_objek
            WHERE o.jenis_objek = 'lapangan'
            ORDER BY dp.created_at DESC, dp.id_detail DESC
        ");

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id)
    {
        DB::update("UPDATE detail_peminjaman SET status = 'approved' WHERE id_detail = ?", [$id]);
        return redirect('/admin/peminjaman')->with('success', 'Peminjaman disetujui!');
    }

    public function reject($id)
    {
        DB::update("UPDATE detail_peminjaman SET status = 'rejected' WHERE id_detail = ?", [$id]);
        return redirect('/admin/peminjaman')->with('success', 'Peminjaman ditolak.');
    }

    public function returnPeminjaman($id)
    {
        DB::update("UPDATE detail_peminjaman SET status = 'returned' WHERE id_detail = ?", [$id]);
        return redirect('/admin/peminjaman')->with('success', 'Peminjaman telah dikembalikan/selesai!');
    }

    // ========== LAPANGAN ==========

    public function objekIndex()
    {
        $objek = DB::select("SELECT * FROM objek WHERE jenis_objek = 'lapangan' ORDER BY nama_objek");
        return view('admin.objek.index', compact('objek'));
    }

    public function objekEdit($id)
    {
        $objek = DB::select("SELECT * FROM objek WHERE id_objek = ? AND jenis_objek = 'lapangan'", [$id]);
        if (empty($objek)) {
            abort(404);
        }
        return view('admin.objek.edit', ['objek' => $objek[0]]);
    }

    public function objekUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_objek' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::update("UPDATE objek SET nama_objek = ?, jumlah = ? WHERE id_objek = ? AND jenis_objek = 'lapangan'", [
            $request->nama_objek,
            $request->jumlah,
            $id
        ]);

        return redirect('/admin/objek')->with('success', 'Objek berhasil diperbarui!');
    }

    public function objekDelete($id)
    {
        DB::delete("DELETE FROM detail_peminjaman WHERE id_objek = ?", [$id]);
        // hapus peminjaman yg tdk pny detail
        DB::delete("DELETE FROM peminjaman WHERE id_peminjaman NOT IN (SELECT id_peminjaman FROM detail_peminjaman)");
        DB::delete("DELETE FROM objek WHERE id_objek = ?", [$id]);

        return redirect('/admin/objek')->with('success', 'Objek berhasil dihapus!');
    }
}
