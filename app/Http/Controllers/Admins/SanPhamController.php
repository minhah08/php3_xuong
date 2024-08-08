<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\DanhMucResquest;
use App\Http\Requests\SanPhamResquest;
use App\Models\DanhMuc;
use App\Models\HinhAnhSanPham;
use App\Models\SanPham;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Sản phẩm ";

        $listSanPham = SanPham::orderByDesc('is_type')->get();

        return view('admins.sanphams.index', compact('title', 'listSanPham'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = " Thêm Mới Sản phẩm ";

        $listDanhMuc = DanhMuc::query()->get();

        return view('admins.sanphams.create', compact('title', 'listDanhMuc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SanPhamResquest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Chuyển đổi giá trị checkbox thành boolean
            $params['is_new'] = $request->has('is_new') ? 1 : 0;
            $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
            $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
            $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

            // Xử lý ảnh đại diện 

            if ($request->hasFile('hinh_anh')) {
                $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            } else {
                $params['hinh_anh'] = null;
            }
            // Thêm sản phẩm
            $sanPham = SanPham::query()->create($params);
            //Lấy id sản phẩm vừa thêm để thêm được album
            $sanPhamID = $sanPham->id;

            // Xuwr lý thêm album 
            if ($request->hasFile('list_hinh_anh')) {
                foreach ($request->file('list_hinh_anh') as $image) {
                    if ($image) {
                        $path = $image->store('uploads/hinhanhsanpham/id_' . $sanPhamID, 'public');
                        $sanPham->hinhAnhSanPham()->create(
                            [
                                'san_pham_id' => $sanPhamID,
                                'hinh_anh' => $path,
                            ]
                        );
                    }
                }
            }

            return redirect()->route('admins.sanphams.index')->with('success', 'Thêm sản phẩm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = " Chỉnh Sửa Sản phẩm ";

        $listDanhMuc = DanhMuc::query()->get();

        $sanPham = SanPham::findOrfail($id);

        return view('admins.sanphams.edit', compact('title', 'listDanhMuc', 'sanPham'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
        
            // Chuyển đổi giá trị checkbox thành boolean
            $params['is_new'] = $request->has('is_new') ? 1 : 0;
            $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
            $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
            $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;
        
            $sanPham = SanPham::findOrFail($id);
        
            // Xử lý ảnh đại diện 
            if ($request->hasFile('hinh_anh')) {
                if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                    Storage::disk('public')->delete($sanPham->hinh_anh);
                }
                $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            } else {
                $params['hinh_anh'] = $sanPham->hinh_anh;
            }
        
            // Xử lý album ảnh
            if ($request->has('list_hinh_anh')) {
                $currentImages = $sanPham->hinhAnhSanPham->pluck('id')->toArray();
        
                // Trường hợp xóa ảnh
                foreach ($currentImages as $imageId) {
                    if (!in_array($imageId, array_keys($request->list_hinh_anh))) {
                        $hinhAnhSanPham = HinhAnhSanPham::find($imageId);
                        if ($hinhAnhSanPham && Storage::disk('public')->exists($hinhAnhSanPham->hinh_anh)) {
                            Storage::disk('public')->delete($hinhAnhSanPham->hinh_anh);
                            $hinhAnhSanPham->delete();
                        }
                    }
                }
        
                // Trường hợp thêm hoặc sửa ảnh
                foreach ($request->list_hinh_anh as $key => $image) {
                    if (is_numeric($key)) {
                        // Trường hợp cập nhật hình ảnh
                        $hinhAnhSanPham = HinhAnhSanPham::find($key);
                        if ($hinhAnhSanPham && $request->hasFile("list_hinh_anh.$key")) {
                            if (Storage::disk('public')->exists($hinhAnhSanPham->hinh_anh)) {
                                Storage::disk('public')->delete($hinhAnhSanPham->hinh_anh);
                            }
                            $path = $image->store("uploads/hinhanhsanpham/id_$id", 'public');
                            $hinhAnhSanPham->update(['hinh_anh' => $path]);
                        }
                    } else {
                        // Trường hợp thêm mới hình ảnh
                        if ($request->hasFile("list_hinh_anh.$key")) {
                            $path = $image->store("uploads/hinhanhsanpham/id_$id", 'public');
                            $sanPham->hinhAnhSanPham()->create([
                                'san_pham_id' => $id,
                                'hinh_anh' => $path,
                            ]);
                        }
                    }
                }
            }
        
            $sanPham->update($params);
            return redirect()->route('admins.sanphams.index')->with('success', 'Cập nhật thông tin sản phẩm thành công');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sanPham = SanPham::findOrfail($id);
        // Xoa hinh anh dai dien cua san pham
        if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
            Storage::disk('public')->delete($sanPham->hinh_anh);
        }

        // Xoa toan bo hinh anh trong thu muc
        $sanPham->hinhAnhSanPham()->delete();

        $path = 'uploads/hinhanhsanpham/id_' . $id;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory($path);
        }

        // Xoa san pham
        $sanPham->delete();

        return redirect()->route('admins.sanphams.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
