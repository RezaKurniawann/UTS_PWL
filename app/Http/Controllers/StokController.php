<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\SupplierModel;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        // Ambil data user beserta levelnya
        $stoks = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('barang', 'user', 'supplier');

        // Filter data user berdasarkan level_id
        if ($request->supplier_id) {
            $stoks->where('supplier_id', $request->supplier_id);
        }

        // Return data untuk DataTables
        return DataTables::of($stoks)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($stok) {

                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $user = UserModel::select('user_id', 'username')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('stok.create_ajax')
            ->with('supplier', $supplier)
            ->with('user', $user)
            ->with('barang', $barang);
    }
    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa ajax atau ingin JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer'
            ];

            // Gunakan Validator dari Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            // Simpan data user
            StokModel::create($request->all());

            // Jika berhasil
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan',
            ]);
        }
        // Redirect jika bukan request Ajax
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $user = UserModel::select('user_id', 'username')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('stok.edit_ajax', ['stok' => $stok, 'supplier' => $supplier, 'user' => $user, 'barang' => $barang]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = StokModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('stok.import');
    }

    public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        // Validasi file harus berformat xlsx dan maksimal ukuran 1MB
        $rules = [
            'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            // Ambil file dari request
            $file = $request->file('file_stok');
            $reader = IOFactory::createReader('Xlsx'); // Load reader file Excel
            $reader->setReadDataOnly(true); // Hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
            $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // Ambil data Excel

            // Siapkan array untuk menampung data yang akan diinsert
            $insert = [];

            if (count($data) > 1) { // Jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // Lewati header
                        if ($value['A'] && $value['B'] && $value['C'] && $value['D'] && $value['E'] && $value['F']) {
                            // Konversi tanggal ke format yang sesuai
                            try {
                                if (is_numeric($value['E'])) {
                                    // Jika data adalah angka, konversi dengan metode Excel
                                    $stok_tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['E']);
                                    $stok_tanggal = $stok_tanggal->format('Y-m-d H:i:s');
                                } else {
                                    // Jika data adalah string, coba konversi dengan format yang ditentukan
                                    $stok_tanggal = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $value['E'])->format('Y-m-d H:i:s');
                                }
                            } catch (\Exception $e) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Format tanggal tidak valid: ' . $e->getMessage()
                                ]);
                            }

                            $insert[] = [
                                'stok_id' => $value['A'],
                                'supplier_id' => $value['B'],
                                'barang_id' => $value['C'],
                                'user_id' => $value['D'],
                                'stok_tanggal' => $stok_tanggal,
                                'stok_jumlah' => $value['F'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    StokModel::insertOrIgnore($insert);

                    return response()->json([
                        'status' => true,
                        'message' => 'Data Stok berhasil diimpor'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data stok yang valid untuk diimpor'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'File kosong atau tidak ada data yang diimpor'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()
            ]);
        }
    }
    return redirect('/');
}

public function export_pdf()
    {
        // Fetching stok data along with supplier and barang details
        $stokData = StokModel::with(['supplier', 'barang', 'user'])
            ->orderBy('supplier_id')
            ->orderBy('barang_id')
            ->get();
    
        // Load the view file for generating the PDF
        $pdf = Pdf::loadView('stok.export_pdf', ['stokData' => $stokData]);
    
        // Set the paper size and orientation
        $pdf->setPaper('a4', 'portrait'); // 'portrait' orientation for A4 paper
    
        // Enable remote access for images
        $pdf->setOption("isRemoteEnabled", true);
    
        // Render the PDF and return as a stream
        return $pdf->stream('Data_Stok_'.date('Y-m-d_H:i:s').'.pdf');
    }

    public function show_ajax(string $stok_id)
    {
        $stok = StokModel::find($stok_id);
        return view('stok.show', ['stok' => $stok]);
    }




}