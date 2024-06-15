<?php

use App\Models\Products;
use App\Mail\WelcomeMail;
use App\Mail\CustomerPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\LaporanKandangController;

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




// Route::post('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi.post');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Route::get('/test-email', function () {
//     $data = ['password' => '123456'];
//     Mail::to('latihancoba95@gmail.com')->send(new CustomerPasswordMail($data)); // assuming you have created a Mailable
// });
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        //get all product
        $products = Products::latest()->get();
        return view('welcome', compact('products'));
    });
    Route::get('/registrasi', function () {
        return view('registrasi');
    })->name('registrasi');
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi.post');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard_kandang', function () {
        return view('dashboard_kandang');
    })->name('dashboard_kandang');
    Route::resource('pendapatan', PendapatanController::class);
    Route::get('/dashboard', function () {
        // customer active
        $customer_active = \App\Models\User::where('status', 'active')->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->count();
        // customer inactive
        $customer_inactive = \App\Models\User::where('status', 'inactive')->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->count();
        // product active
        $product_active = Products::where('status', '1')->count();
        // product inactive
        $product_inactive = Products::where('status', '0')->count();
        // ambil product 10 terakhir yang diinput
        $products = Products::take(10)->latest()->get();
        // dd($products);
        return view('dashboard', compact('products', 'customer_active', 'customer_inactive', 'product_active', 'product_inactive'));
    })->name('dashboard');
    Route::resource('products', ProductsController::class);
    Route::resource('jenis-produk', JenisProdukController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('manage-kandang', [KandangController::class, 'index'])->name('manage-kandang.index');
    Route::get('detail-kandang/{id}', [KandangController::class, 'show'])->name('detail-kandang.show');
    Route::post('tambah-pengeluaran', [KandangController::class, 'store'])->name('tambah-pengeluaran.store');
    Route::put('edit-pengeluaran/{id}', [KandangController::class, 'update'])->name('tambah-pengeluaran.update');
    Route::delete('hapus-pengeluaran/{id}', [KandangController::class, 'destroy'])->name('tambah-pengeluaran.destroy');
    Route::get('/customers/ubah-status/{id}', [CustomerController::class, 'ubahStatus'])->name('customers.ubah-status');
    // route laporan admin
    Route::get('laporan-admin', [LaporanAdmin::class, 'index'])->name('laporan-admin.index');
    Route::get('laporan-admin/{id}', [LaporanAdmin::class, 'show'])->name('laporan-admin.show');
    // print laporan admin
    Route::get('print-laporan-admin/{id}/{date}', [LaporanAdmin::class, 'print'])->name('print-laporan-admin');
    // laporkan kandang
    Route::get('laporkan-kandang', [LaporanKandangController::class, 'index'])->name('laporkan-kandang.index');
    Route::get('laporkan-kandang/{id}', [LaporanKandangController::class, 'show'])->name('laporkan-kandang.show');
    // print laporan
    Route::get('print-laporan/{id}', [LaporanKandangController::class, 'print'])->name('print-laporan');
    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout successful');
    })->name('logout');
});

// Route::resource('products', ProductsController::class);
