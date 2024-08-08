<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\DanhMucResquest;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Danh mục sản phẩm ";
        $listDanhMuc = DanhMuc::orderByDesc('trang_thai')->get();
        return view('admins.danhmucs.index', compact('title', 'listDanhMuc'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm mới danh mục sản phẩm ";
        return view('admins.danhmucs.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanhMucResquest $request)
    {
        if ($request->isMethod('POST')) {

            $params = $request->except('_token');

            if ($request->hasFile('hinh_anh')) {
                $fileName = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
            } else {
                $fileName = null;
            }

            $params['hinh_anh'] = $fileName;

            DanhMuc::create($params);

            return redirect()->route('admins.danhmucs.index')->with('success', 'Thêm mới danh mục thành công');
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
        $title = "Chỉnh sửa danh mục sản phẩm";

        $danhMuc = DanhMuc::findOrfail($id);

        return view('admins.danhmucs.edit', compact('title', 'danhMuc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {

            $params = $request->except('_token', '_method');
            $danhMuc = DanhMuc::findOrfail($id);

            if ($request->hasFile('hinh_anh')) {
                if ($danhMuc->hinh_anh && Storage::disk('public')->exists($danhMuc->hinh_anh)){
                    Storage::disk('public')->delete($danhMuc->hinh_anh);
                }
                $fileName = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
            } else {
                $fileName = $danhMuc->hinh_anh;
            }

            $params['hinh_anh'] = $fileName;

            $danhMuc->update($params);

            return redirect()->route('admins.danhmucs.index')->with('success', 'Thêm mới danh mục thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $danhMuc = DanhMuc::findOrfail($id);

        $danhMuc->delete();

        if ($danhMuc->hinh_anh && Storage::disk('public')->exists($danhMuc->hinh_anh)){
            Storage::disk('public')->delete($danhMuc->hinh_anh);
        }

        return redirect()->route('admins.danhmucs.index')->with('success', 'Xóa danh mục thành công');
    }
}
