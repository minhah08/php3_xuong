<?php

use App\Http\Controllers\Admins\AuthController;
use App\Http\Controllers\Admins\DanhMucController;
use App\Http\Controllers\Admins\DonHangController;
use App\Http\Controllers\Admins\SanPhamController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/danhmucs', function () {
    return view('admins.danhmucs.index');
});

Route::get('login', [AuthController::class, 'showFormLogin']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/home', function(){
//     return view('home');
// })->middleware('auth');

// Route::get('/admin', function(){
//      return 'Day la trang admin';
// })->middleware('auth','auth.admin');

// Route::middleware('auth')->group(function (){
//       Route::get('/home', function(){
//            return view('home');
//       });
// });

// Route::middleware('auth','auth.admin')->group(function (){
//       Route::get('/admin', function(){
//            return 'Day la trang admin';
//       });
// });


// Route admin
// Auth::routes();

// Route::get('/home',                            [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
Route::get('/trangchu',                        [ProductController::class, 'index'])->name('trangchu');
Route::get('/product/detail/{id}',             [ProductController::class, 'chiTietSanPham'])->name('products.detail');
Route::get('/list-cart',                       [CartController::class, 'listCart'])->name('cart.list');
Route::post('/add-cart',                       [CartController::class, 'addCart'])->name('cart.add');
Route::post('/update-cart',                    [CartController::class, 'updateCart'])->name('cart.update');

 // Danh muc
 Route::middleware('auth')->prefix('donhangs')
 ->as('donhangs.')
 ->group(function () { 
     Route::get('/',                           [OrderController::class, 'index'])->name('index');
     Route::get('/create',                     [OrderController::class, 'create'])->name('create');
     Route::post('/store',                     [OrderController::class, 'store'])->name('store');
     Route::get('/show/{id}',                  [OrderController::class, 'show'])->name('show');
     Route::put('{id}/update',                 [OrderController::class, 'update'])->name('update');
 });

 // Admin
Route::middleware(['auth', 'auth.admin'])->prefix('admins')
    ->as('admins.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admins.dashboard');
        })->name('dashboard');

        // Danh muc
        Route::prefix('danhmucs')
            ->as('danhmucs.')
            ->group(function () {
                Route::get('/',                [DanhMucController::class, 'index'])->name('index');
                Route::get('/create',          [DanhMucController::class, 'create'])->name('create');
                Route::post('/store',          [DanhMucController::class, 'store'])->name('store');
                Route::get('/show/{id}',       [DanhMucController::class, 'show'])->name('show');
                Route::get('{id}/edit',        [DanhMucController::class, 'edit'])->name('edit');
                Route::put('{id}/update',      [DanhMucController::class, 'update'])->name('update');
                Route::delete('{id}/destroy',  [DanhMucController::class, 'destroy'])->name('destroy');
            });

        // San pham
        Route::prefix('sanphams')
            ->as('sanphams.')
            ->group(function () {
                Route::get('/',                [SanPhamController::class, 'index'])->name('index');
                Route::get('/create',          [SanPhamController::class, 'create'])->name('create');
                Route::post('/store',          [SanPhamController::class, 'store'])->name('store');
                Route::get('/show/{id}',       [SanPhamController::class, 'show'])->name('show');
                Route::get('{id}/edit',        [SanPhamController::class, 'edit'])->name('edit');
                Route::put('{id}/update',      [SanPhamController::class, 'update'])->name('update');
                Route::delete('{id}/destroy',  [SanPhamController::class, 'destroy'])->name('destroy');
            });
        // Don hang
        Route::prefix('donhangs')
            ->as('donhangs.')
            ->group(function () {
                Route::get('/',                [DonHangController::class, 'index'])->name('index');
                Route::get('/show/{id}',       [DonHangController::class, 'show'])->name('show');
                Route::put('{id}/update',      [DonHangController::class, 'update'])->name('update');
                Route::delete('{id}/destroy',  [DonHangController::class, 'destroy'])->name('destroy');
            });
    });
