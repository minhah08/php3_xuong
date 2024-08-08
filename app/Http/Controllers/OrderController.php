<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OderConFimr;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donHangs = Auth::user()->donHang;
        
        $trangThaiDonHang = DonHang::TRANG_THAI_DON_HANG;

        $type_cho_xac_nhan = DonHang::CHO_XAC_NHAN;

        $type_dang_van_chuyen = DonHang::DANG_VAN_CHUYEN;

        return view('clients.donhangs.index', compact('donHangs', 'trangThaiDonHang', 'type_cho_xac_nhan', 'type_dang_van_chuyen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carts = session()->get('cart', []);
        if (!empty($carts)) {
            $total = 0;
            $subTotal = 0;

            foreach ($carts as $item) {
                $subTotal += $item['gia'] * $item['so_luong'];
            }

            $shipping = 30000;

            $total = $subTotal + $shipping;

            return view('clients.donhangs.create', compact('carts', 'subTotal', 'shipping', 'total'));
        }
        return redirect()->route('cart.list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction();

            try {
                // Lấy tất cả các tham số từ yêu cầu, trừ `_token`
                $params = $request->except('_token');

                // Tạo mã đơn hàng duy nhất
                $params['ma_don_hang'] = $this->generateUniqueOrderCode();

          
                // Tạo đơn hàng mới trong cơ sở dữ liệu
                $donHang = DonHang::query()->create($params);
                $donHangId = $donHang->id;
                // Lấy giỏ hàng từ session
                $carts = session()->get('cart', []);
              
                // Lặp qua từng sản phẩm trong giỏ hàng và thêm vào chi tiết đơn hàng
                foreach ($carts as $key => $item) { 
                    $thanhTien = $item['gia'] * $item['so_luong'];
                    
                    $donHang->chiTietDonHang()->create([
                        'don_hang_id' => $donHangId,
                        'san_pham_id' => $key,
                        'don_gia' => $item['gia'],
                        'so_luong' => $item['so_luong'],
                        'thanh_tien' => $thanhTien
                    ]);
                }

                // Commit giao dịch nếu không có lỗi xảy ra
                DB::commit();
                // Xóa giỏ hàng sau khi tạo đơn hàng thành công

                // Gui mail khi dat hang thanh cong
                Mail::to($donHang->email_nguoi_nhan)->queue(new OderConFimr($donHang));
                session()->put('cart', []);
                
                // Chuyển hướng đến trang danh sách đơn hàng với thông báo thành công
                return redirect()->route('donhangs.index')->with('success', 'Đơn hàng đã được tạo thành công');
            } catch (\Exception $e) {
                // Rollback giao dịch nếu có lỗi xảy ra
                DB::rollBack();
                // Chuyển hướng đến trang giỏ hàng với thông báo lỗi
                return redirect()->route('cart.list')->with('error', 'Có lỗi khi tạo đơn hàng. Vui lòng thử lại sau');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donHang = DonHang::query()->findOrFail($id);
        
        $trangThaiDonHang = DonHang::TRANG_THAI_DON_HANG;
        
        $trangThaiThanhToan = DonHang::TRANG_THAI_THANH_TOAN;

        return view('clients.donhangs.show', compact('donHang', 'trangThaiDonHang', 'trangThaiThanhToan'));

    }


    public function update(Request $request, string $id)
    {
        $donHang = DonHang::query()->findOrFail($id);

        DB::beginTransaction();

        try {
            if ($request->has('huy_don_hang')) {
                $donHang->update(['trang_thai_don_hang' => DonHang::HUY_DON_HANG]);
            }elseif ($request->has('da_giao_hang')){
                $donHang->update(['trang_thai_don_hang' => DonHang::DA_GIAO_HANG]);
            }

            DB::commit();

            return redirect()->back();
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
        } while (DonHang::where('ma_don_hang', $orderCode)->exists());

        return $orderCode;
    }
}
