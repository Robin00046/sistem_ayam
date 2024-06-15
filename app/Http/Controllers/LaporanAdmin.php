<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendapatan;
use App\Models\JenisProduk;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanAdmin extends Controller
{
    // index laporan
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'kandang');
        })->get();
        return view('admin.laporan.index')->with('users', $users);
    }

    public function show($id, Request $request)
    {
        //
        $user = User::find($id);
        $date = Pengeluaran::selectRaw('DATE_FORMAT(created_at, "%M %Y") as date')->distinct()->get();
        if ($request->date) {
            $pengeluaran = Pengeluaran::where('kandang_id', $id)->whereRaw("DATE_FORMAT(created_at, '%M %Y') = '$request->date'")->with('jenisProduk')->latest()->get();
            $pengeluaran_perbulan_tahun = Pengeluaran::where('kandang_id', $id)->whereRaw("DATE_FORMAT(created_at, '%M %Y') = '$request->date'")->get();
        } else {
            $pengeluaran = Pengeluaran::where('kandang_id', $id)->with('jenisProduk')->latest()->get();
            $pengeluaran_perbulan_tahun = Pengeluaran::where('kandang_id', $id)->get();
        }

        // dd($pengeluaran);
        $jenisProduks = JenisProduk::all();


        foreach ($pengeluaran_perbulan_tahun as $key => $value) {
            $jumlah_total_pengeluaran_perbulan_tahun[$value->created_at] = $pengeluaran_perbulan_tahun->where('created_at', $value->created_at)->sum('total');
        }

        $pendapatan_perbulan_tahun = Pendapatan::where('id_kandang', $id)->get();
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


        // dd($data);


        return view('admin.laporan.show', compact('user', 'pengeluaran', 'jenisProduks', 'data', 'date'));
    }

    public function print($id, $date)
    {
        $id = User::find($id);
        // date = May 2021
        // get pendapatan where MonthYear(created_at) = date
        $pendapatan = Pendapatan::whereRaw("DATE_FORMAT(created_at, '%M %Y') = '$date'")->get();
        // get pengeluaran where MonthYear(created_at) = date
        $pengeluaran = Pengeluaran::whereRaw("DATE_FORMAT(created_at, '%M %Y') = '$date'")->get();
        // get total pendapatan
        $total_pendapatan = number_format($pendapatan->sum('total'), 0, ',', '.');
        // get total pengeluaran
        $total_pengeluaran = number_format($pengeluaran->sum('total'), 0, ',', '.');
        // get total keuntungan
        $total_keuntungan = number_format($pendapatan->sum('total') - $pengeluaran->sum('total'), 0, ',', '.');

        // gabungkan total pendapatan dan total pengeluaran dan total keuntungan
        $data = [
            'total_pendapatan' => $total_pendapatan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_keuntungan' => $total_keuntungan
        ];
        // dd($data);

        return view('kandang.laporan.print', compact('pendapatan', 'pengeluaran', 'total_pendapatan', 'total_pengeluaran', 'data'));
    }
}
