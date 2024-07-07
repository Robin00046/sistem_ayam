<?php

use App\Models\User;
use App\Models\Products;
use App\Mail\WelcomeMail;
use App\Models\JenisProduk;
use App\Models\Pengeluaran;
use App\Mail\CustomerPasswordMail;
use Illuminate\Support\Facades\Auth;
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
use App\Models\Pendapatan;

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
        return redirect()->route('login');
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
        //
        $id = Auth::user()->id;
        // get bulan dan tahun dari created_at
        $date = Pengeluaran::selectRaw('DATE_FORMAT(created_at, "%M %Y") as date')->where('kandang_id', $id)->distinct()->get();

        $pengeluaran = Pengeluaran::where('kandang_id', $id)->with('jenisProduk')->latest()->get();
        $pengeluaran_perbulan_tahun = Pengeluaran::where('kandang_id', $id)->orderBy('created_at', 'desc')->get();
        if ($pengeluaran_perbulan_tahun->isEmpty()) {
            $data = [];
        } else {
            $jumlah_total_pengeluaran_perbulan_tahun = $pengeluaran_perbulan_tahun->groupBy('created_at')->map(function ($item) {
                return $item->sum('total');
            });
            // foreach ($pengeluaran_perbulan_tahun as $key => $value) {
            //     $jumlah_total_pengeluaran_perbulan_tahun[$value->created_at] = $pengeluaran_perbulan_tahun->where('created_at', $value->created_at)->sum('total');
            // }
            // foreach ($pengeluaran_perbulan_tahun as $key => $value) {
            //     $jumlah_total_pengeluaran_perbulan_tahun[$value->created_at] = $pengeluaran_perbulan_tahun->where('created_at', $value->created_at)->sum('total');
            // }

            $pendapatan_perbulan_tahun = Pendapatan::where('id_kandang', $id)->orderBy('created_at', 'desc')->get();
            // dd($pendapatan_perbulan_tahun);
            // dd($pendapatan_perbulan_tahun);
            foreach ($pendapatan_perbulan_tahun as $key => $value) {
                $jumlah_total_pendapatan_perbulan_tahun[$value->created_at] = $pendapatan_perbulan_tahun->where('created_at', $value->created_at)->sum('total');
                // dd($jumlah_total_pendapatan_perbulan_tahun);
            }
            // gabungkan pengeluaran dan pendapatan

            $data = [];
            foreach ($jumlah_total_pengeluaran_perbulan_tahun as $key => $value) {
                $data[$key] = [
                    'bulan' => $key,
                    'pengeluaran' => $value,
                    'pemasukan' => $jumlah_total_pendapatan_perbulan_tahun[$key] ?? 0,
                    'keuntungan' => ($jumlah_total_pendapatan_perbulan_tahun[$key] ?? 0) - $value
                ];
            }
        }
        // ambil data pertama
        // dd($data);
        $test = $data[array_key_first($data)];
        // dd($test);
        return view('dashboard_kandang', compact('test'));
    })->name('dashboard_kandang');
    Route::resource('pendapatan', PendapatanController::class);
    Route::get('/dashboard', function () {
        // kandang active
        $customer_active = User::where('status', 'active')->whereHas('roles', function ($query) {
            $query->where('name', 'kandang');
        })->count();
        // kandang inactive
        $customer_inactive = User::where('status', 'inactive')->whereHas('roles', function ($query) {
            $query->where('name', 'kandang');
        })->count();
        // jumlah produk 
        $product_active = JenisProduk::all()->count();
        // ambil product 10 terakhir yang diinput
        $products = Products::take(10)->latest()->get();
        // dd($products);
        return view('dashboard', compact('products', 'customer_active', 'customer_inactive', 'product_active'));
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
