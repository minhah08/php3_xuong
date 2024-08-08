<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_san_pham',
        'ten_san_pham',
        'hinh_anh',
        'gia_san_pham',
        'gia_khuyen_mai',
        'mo_ta_ngan',
        'noi_dung',
        'so_luong',
        'luot_xem',
        'ngay_nhap',
        'danh_muc_id',
        'is_type',
        'is_new',
        'is_hot',
        'is_hot_deal',
        'is_show_home',
    ];

    protected $carts = [
        'is_type' => 'boolean',
        'is_new' => 'boolean',
        'is_hot' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_show_home' => 'boolean',
     ];

    public function danhMuc() {
        return $this->belongsTo(DanhMuc::class);
    }

    public function hinhAnhSanPham() {
        return $this->hasMany(HinhAnhSanPham::class);
    }
}
