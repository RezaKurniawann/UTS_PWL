<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds for t_stok table.
     *
     * This seeder inserts sample data into the t_stok table.
     */
    public function run(): void
    {
        DB::table('t_stok')->insert([
            // Sample data for stok
            ['supplier_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 100],
            ['supplier_id' => 2, 'barang_id' => 2, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 50],
            ['supplier_id' => 1, 'barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => now()->subDays(1), 'stok_jumlah' => 200],
            ['supplier_id' => 3, 'barang_id' => 4, 'user_id' => 2, 'stok_tanggal' => now()->subDays(2), 'stok_jumlah' => 75],
            ['supplier_id' => 2, 'barang_id' => 5, 'user_id' => 1, 'stok_tanggal' => now()->subDays(3), 'stok_jumlah' => 30],
            ['supplier_id' => 1, 'barang_id' => 6, 'user_id' => 2, 'stok_tanggal' => now()->subDays(4), 'stok_jumlah' => 120],
            ['supplier_id' => 2, 'barang_id' => 7, 'user_id' => 1, 'stok_tanggal' => now()->subDays(5), 'stok_jumlah' => 60],
            ['supplier_id' => 3, 'barang_id' => 8, 'user_id' => 2, 'stok_tanggal' => now()->subDays(6), 'stok_jumlah' => 90],
            ['supplier_id' => 1, 'barang_id' => 9, 'user_id' => 1, 'stok_tanggal' => now()->subDays(7), 'stok_jumlah' => 45],
            ['supplier_id' => 2, 'barang_id' => 10, 'user_id' => 2, 'stok_tanggal' => now()->subDays(8), 'stok_jumlah' => 150],
            ['supplier_id' => 3, 'barang_id' => 11, 'user_id' => 1, 'stok_tanggal' => now()->subDays(9), 'stok_jumlah' => 85],
            ['supplier_id' => 1, 'barang_id' => 12, 'user_id' => 2, 'stok_tanggal' => now()->subDays(10), 'stok_jumlah' => 40],
            ['supplier_id' => 2, 'barang_id' => 13, 'user_id' => 1, 'stok_tanggal' => now()->subDays(11), 'stok_jumlah' => 70],
            ['supplier_id' => 3, 'barang_id' => 14, 'user_id' => 2, 'stok_tanggal' => now()->subDays(12), 'stok_jumlah' => 110],
            ['supplier_id' => 1, 'barang_id' => 15, 'user_id' => 1, 'stok_tanggal' => now()->subDays(13), 'stok_jumlah' => 30],
            ['supplier_id' => 2, 'barang_id' => 1, 'user_id' => 2, 'stok_tanggal' => now()->subDays(14), 'stok_jumlah' => 80],
            ['supplier_id' => 3, 'barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => now()->subDays(15), 'stok_jumlah' => 100],
            ['supplier_id' => 1, 'barang_id' => 3, 'user_id' => 2, 'stok_tanggal' => now()->subDays(16), 'stok_jumlah' => 95],
            ['supplier_id' => 2, 'barang_id' => 4, 'user_id' => 1, 'stok_tanggal' => now()->subDays(17), 'stok_jumlah' => 65],
            ['supplier_id' => 3, 'barang_id' => 5, 'user_id' => 2, 'stok_tanggal' => now()->subDays(18), 'stok_jumlah' => 120],
            ['supplier_id' => 1, 'barang_id' => 6, 'user_id' => 1, 'stok_tanggal' => now()->subDays(19), 'stok_jumlah' => 130],
        ]);
    }
}
