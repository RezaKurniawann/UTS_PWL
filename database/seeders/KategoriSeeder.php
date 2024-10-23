<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            ['kategori_id' => 1 , 'kategori_kode' => 'KTG01', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'KTG02', 'kategori_nama' => 'Furnitur'],
            ['kategori_id' => 3, 'kategori_kode' => 'KTG03', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 4, 'kategori_kode' => 'KTG04', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 5, 'kategori_kode' => 'KTG05', 'kategori_nama' => 'Minuman'],

            [
                'kategori_id' => 6,
                'kategori_kode' => 'SBK',
                'kategori_nama' => 'Sembako',
            ],
            [
                'kategori_id' => 7,
                'kategori_kode' => 'SNK',
                'kategori_nama' => 'Makanan Ringan',
            ],
            [
                'kategori_id' => 8,
                'kategori_kode' => 'MND',
                'kategori_nama' => 'Peralatan Bayi',
            ],
            [
                'kategori_id' => 9,
                'kategori_kode' => 'BAY',
                'kategori_nama' => 'Keperluan Bayi',
            ],
            [
                'kategori_id' => 10,
                'kategori_kode' => 'MNM',
                'kategori_nama' => 'Minuman',
            ],
        ]);
    }
}
