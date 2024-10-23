<?php
namespace App\Http\Controllers;
use App\Models\SupplierModel; // Pastikan nama model menggunakan huruf besar
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;


class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'supplier']
        ];
        $page = (object)[
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier';
        return view('supplier.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }
    public function list(Request $request)
{
    $supplier = suppliermodel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');
    return DataTables::of($supplier)
        ->addIndexColumn() // Menambahkan kolom index
        ->addColumn('aksi', function ($supplier) {
            $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
            //     . csrf_field() . method_field('DELETE') .
            //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // Menandakan bahwa kolom aksi adalah HTML
        ->make(true);
}
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'supplier', 'tambah']
        ];
        $page = (object)[
            'title' => 'Tambah supplier baru'
        ];
        $activeMenu = 'supplier';
        return view('supplier.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|min:3|max:5|unique:m_supplier,supplier_kode',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255' // Memperpanjang batas maksimum untuk alamat
        ]);
        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);
        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }
    public function show(string $supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        $breadcrumb = (object)[
            'title' => 'Detail Supplier',
            'list' => ['Home', 'supplier', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail Supplier'
        ];
        $activeMenu = 'supplier';
        return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'supplier' => $supplier
        ]);
    }
    public function edit(string $supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        $breadcrumb = (object)[
            'title' => 'Edit Supplier',
            'list' => ['Home', 'supplier', 'edit']
        ];
        $page = (object)[
            'title' => 'Edit Supplier'
        ];
        $activeMenu = 'supplier';
        return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }
    public function update(Request $request, string $supplier_id)
    {
        $request->validate([
            'supplier_kode' => 'required|string|min:3|max:5|unique:m_supplier,supplier_kode,' . $supplier_id . ',supplier_id', // Tambahkan pengecualian untuk update
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255' // Memperpanjang batas maksimum untuk alamat
        ]);
        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        $supplier->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);
        return redirect('/supplier')->with('success', 'Data supplier berhasil diperbarui');
    }
    public function destroy(string $supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        try {
            $supplier->delete(); // Menghapus supplier dengan cara yang lebih aman
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|max:20|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama' => 'required|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
                'supplier_alamat' => 'required|string|max:100'
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
            $check = SupplierModel::find($id);
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
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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
    // Menampilkan halaman form edit supplier ajax
    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode'    => 'required|string|min:3|unique:m_supplier,supplier_kode',
                'supplier_nama'    => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:100'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            SupplierModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data supplier berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function import()
    {
        return view('supplier.import');
    }

    public function import_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            // Validasi file harus berformat xlsx dan maksimal ukuran 1MB
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                // Ambil file dari request
                $file = $request->file('file_supplier'); 
                $reader = IOFactory::createReader('Xlsx'); // Load reader file Excel
                $reader->setReadDataOnly(true); // Hanya membaca data
                $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
                $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
                $data = $sheet->toArray(null, false, true, true); // Ambil data Excel

                // Siapkan array untuk menampung data yang akan diinsert
                $insert = [];
                
                if(count($data) > 1){ // Jika data lebih dari 1 baris
                    foreach ($data as $baris => $value) {
                        if($baris > 1){ // Baris ke-1 adalah header, maka lewati
                            // Pastikan semua kolom tidak kosong sebelum insert
                            if ($value['A'] && $value['B'] && $value['C'] && $value['D']) {
                                $insert[] = [
                                    'supplier_id' => $value['A'],
                                    'supplier_kode' => $value['B'],
                                    'supplier_nama' => $value['C'],
                                    'supplier_alamat' => $value['D'],
                                    'created_at' => now(),
                                ];
                            }
                        }
                    }

                    if(count($insert) > 0){
                        // Insert data ke database, jika data sudah ada, maka diabaikan
                        SupplierModel::insertOrIgnore($insert);

                        return response()->json([
                            'status' => true,
                            'message' => 'Data supplier berhasil diimpor'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Tidak ada data supplier yang valid untuk diimpor'
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

    public function export_excel()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama')  
            ->orderBy('Supplier_id')        
            ->get();
            
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Kode Supplier');
            $sheet->setCellValue('C1', 'Nama Supplier');

            $sheet->getStyle('A1:C1')->getFont()->setBold(true);

            $no = 1;
            // nomor data dimulai dari 1
            $baris = 2;
            // baris data dimulai dari baris ke 2
            foreach ($supplier as $key => $value) {
                $sheet->setCellValue('A'.$baris, $no);
                $sheet->setCellValue('B'.$baris, $value->supplier_kode);
                $sheet->setCellValue('C'.$baris, $value->supplier_nama);
                $baris++;
                $no++;
            }
            foreach (range('A', 'C') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            $sheet->setTitle('Data Supplier'); 
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data Supplier '.date('Y-m-d H:i:s').'.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Cache-Control: cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified:'. gmdate('D, dMY H:i:s'). 'GMT'); 
            header('Pragma: public');
            $writer->save('php://output');
            exit;
    } 

    public function export_pdf()
    {
        $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama')
        ->orderBy('supplier_id') ->orderBy('supplier_kode')
        ->get();

        $pdf = Pdf::loadView('supplier.export_pdf', ['supplier' => $supplier]);
        $pdf->setPaper ('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream ('Data Supplier '.date('Y-m-d H:i:s').'.pdf');
    }

    // public function show_ajax(string $supplier_id)
    // {
    //     $supplier = suppliermodel::find($supplier_id);
    //     return view('supplier.show', ['supplier' => $supplier]);
    // }
}