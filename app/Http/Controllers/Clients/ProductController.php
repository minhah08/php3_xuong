<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index() {
        $sanPham = SanPham::query()->get();
        return view('clients.index', compact('sanPham'));
    }
    public function chiTietSanPham(string $id) {

        $sanPham = SanPham::query()->findOrFail($id);

        $listSanPham = SanPham::query()->get();

        return view('clients.sanphams.chitiet' , compact('sanPham', 'listSanPham'));
    }


}
