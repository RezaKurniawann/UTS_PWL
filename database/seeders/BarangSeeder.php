<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            ['kategori_id' => 1, 'barang_kode' => 'BRG01', 'barang_nama' => 'TV', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG02', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 5500000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG03', 'barang_nama' => 'Kulkas', 'harga_beli' => 2500000, 'harga_jual' => 3000000],
            
            ['kategori_id' => 2, 'barang_kode' => 'BRG04', 'barang_nama' => 'Sofa', 'harga_beli' => 1500000, 'harga_jual' => 1800000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG05', 'barang_nama' => 'Meja', 'harga_beli' => 500000, 'harga_jual' => 700000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG06', 'barang_nama' => 'Kursi', 'harga_beli' => 300000, 'harga_jual' => 500000],
        
            ['kategori_id' => 3, 'barang_kode' => 'BRG07', 'barang_nama' => 'Kaos', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG08', 'barang_nama' => 'Celana', 'harga_beli' => 100000, 'harga_jual' => 150000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG09', 'barang_nama' => 'Jaket', 'harga_beli' => 200000, 'harga_jual' => 250000],
        
            ['kategori_id' => 4, 'barang_kode' => 'BRG10', 'barang_nama' => 'Roti', 'harga_beli' => 20000, 'harga_jual' => 30000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG11', 'barang_nama' => 'Biskuit', 'harga_beli' => 15000, 'harga_jual' => 25000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG12', 'barang_nama' => 'Cake', 'harga_beli' => 50000, 'harga_jual' => 75000],
        
            ['kategori_id' => 5, 'barang_kode' => 'BRG13', 'barang_nama' => 'Susu', 'harga_beli' => 10000, 'harga_jual' => 20000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG14', 'barang_nama' => 'Jus', 'harga_beli' => 5000, 'harga_jual' => 10000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG15', 'barang_nama' => 'Teh', 'harga_beli' => 15000, 'harga_jual' => 25000],

            [
                'kategori_id' => 6,
                'barang_kode' => 'SBK-001',
                'barang_nama' => 'Beras Cap Jago (5kg)',
                'harga_beli' => 65000,
                'harga_jual' => 68000
            ],
            [
                'kategori_id' => 6,
                'barang_kode' => 'SBK-002',
                'barang_nama' => 'Beras Bramo Cap Lele',
                'harga_beli' => 80000,
                'harga_jual' => 83000
            ],
            [
                'kategori_id' => 7,
                'barang_kode' => 'SNK-001',
                'barang_nama' => 'Happy Tos',
                'harga_beli' => 10500,
                'harga_jual' => 11000
            ],
            [
                'kategori_id' => 7,
                'barang_kode' => 'SNK-002',
                'barang_nama' => 'Oreo',
                'harga_beli' => 7200,
                'harga_jual' => 7800
            ],
            [
                'kategori_id' => 8,
                'barang_kode' => 'MND-001',
                'barang_nama' => 'Sabun Lifebouy',
                'harga_beli' => 4250,
                'harga_jual' => 5000
            ],
            [
                'kategori_id' => 8,
                'barang_kode' => 'MND-002',
                'barang_nama' => 'Pasta Gigi Pepsoden',
                'harga_beli' => 6750,
                'harga_jual' => 7500
            ],
            [
                'kategori_id' => 9,
                'barang_kode' => 'BAY-001',
                'barang_nama' => 'Susu SGM Coklat 900gr',
                'harga_beli' => 92500,
                'harga_jual' => 95000
            ],
            [
                'kategori_id' => 9,
                'barang_kode' => 'BAY-002',
                'barang_nama' => 'Popok Mamy Poko',
                'harga_beli' => 56000,
                'harga_jual' => 58000
            ],
            [
                'kategori_id' => 10,
                'barang_kode' => 'MNM-001',
                'barang_nama' => 'Aqua 600ml',
                'harga_beli' => 3700,
                'harga_jual' => 4500
            ],
            [
                'kategori_id' => 10,
                'barang_kode' => 'MNM-002',
                'barang_nama' => 'Le Mineral',
                'harga_beli' => 3500,
                'harga_jual' => 4000
            ]

        ]); 
    }
}
