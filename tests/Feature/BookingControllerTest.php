<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that approving a pending booking reduces the stock immediately.
     */
    public function test_approve_booking_reduces_stock()
    {
        // ----- 1. Prepare data -------------------------------------------------
        // Create a dummy user (Mahasiswa role)
        $userId = DB::table('users')->insertGetId([
            'nama_user' => 'Test Mahasiswa',
            'password' => bcrypt('secret'),
            'role' => 'Mahasiswa',
        ]);
        // Create an object (barang) with known stock
        $objekId = DB::table('objek')->insertGetId([
            'nama_objek' => 'Bola Basket',
            'jenis_objek' => 'barang',
            'jumlah' => 10,
            'id_user' => $userId,
        ]);

        // Create a peminjaman (parent record)
        $peminjamanId = DB::table('peminjaman')->insertGetId([
            'id_user' => $userId,
            'tanggal_pengajuan' => now()->toDateString(),
            'kegiatan' => 'Uji Unit',
        ]);

        // Create detail_peminjaman (pending request)
        $detailId = DB::table('detail_peminjaman')->insertGetId([
            'id_peminjaman' => $peminjamanId,
            'id_objek' => $objekId,
            'jumlah_pinjam' => 3,
            'tipe_pinjam' => 'per_hari',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'jam_mulai' => null,
            'jam_selesai' => null,
            'status' => 'pending',
        ]);

        // ----- 2. Simulate Mahasiswa session -----------------------------------
        $sessionUser = (object) [
            'id_user' => $userId,
            'role' => 'Mahasiswa',
        ];

        // ----- 3. Perform the approval request -------------------------------
        $response = $this->withSession(['user' => $sessionUser])
                         ->withoutMiddleware()
                         ->patch('/mahasiswa/permintaan-masuk/' . $detailId . '/approve');

        // ----- 4. Assertions ---------------------------------------------------
        $response->assertRedirect('/mahasiswa/permintaan-masuk')
                 ->assertSessionHas('success');

        // Stock should be reduced from 10 to 7
        $newStock = DB::table('objek')->where('id_objek', $objekId)->value('jumlah');
        $this->assertEquals(7, $newStock, 'Stock was not reduced correctly after approval');

        // Detail status should be approved
        $status = DB::table('detail_peminjaman')->where('id_detail', $detailId)->value('status');
        $this->assertEquals('approved', $status, 'Detail status was not set to approved');
    }
}
?>
