<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\Models\LevelModel;


class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'dashboard';

        // Dapatkan jumlah user dan supplier
        $userCount = UserModel::count();
        $supplierCount = SupplierModel::count();
        $kategoriCount = KategoriModel::count();
        $barangCount = BarangModel::count();
        $levelCount = LevelModel::count();

        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'userCount' => $userCount,
            'supplierCount' => $supplierCount,
            'kategoriCount' => $kategoriCount,
            'barangCount' => $barangCount,
            'levelCount' => $levelCount
        ]);
    }
}

?>