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

    public function show($id)
    {
        //
        $user = User::find($id);

        $pengeluaran = Pengeluaran::where('kandang_id', $id)->with('jenisProduk')->latest()->get();
        // dd($pengeluaran);
        $jenisProduks = JenisProduk::all();

        $pengeluaran_perbulan_tahun = Pengeluaran::where('kandang_id', $id)->get();

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


        return view('admin.laporan.show', compact('user', 'pengeluaran', 'jenisProduks', 'data'));
    }
}
