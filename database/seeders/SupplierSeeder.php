<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_kode' => 'SUP01',
                'supplier_nama' => 'PT. Sumber Makmur',
                'supplier_alamat' => 'Jl. Raya Industri No. 15, Jakarta',
            ],
            [
                'supplier_kode' => 'SUP02',
                'supplier_nama' => 'CV. Maju Jaya',
                'supplier_alamat' => 'Jl. Merdeka No. 10, Bandung',
            ],
            [
                'supplier_kode' => 'SUP03',
                'supplier_nama' => 'UD. Toko Sukses',
                'supplier_alamat' => 'Jl. Veteran No. 22, Surabaya',
            ],
        ]);
    }
}
