<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisProduk;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    // indwx kandang

    public function index()
    {
        // get all user
        $users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role')
            ->where('roles.name', 'kandang')
            ->get();
        return view('manage-kandang.index', compact('users'));
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





        return view('manage-kandang.show', compact('user', 'pengeluaran', 'jenisProduks'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // tambah pengeluaran kandang
        $jenisProduks = JenisProduk::where('id', $request->jenis_produk_id)->first();

        $this->validate($request, [
            'kandang_id' => 'required',
            'jenis_produk_id' => 'required',
            'jumlah' => 'required',
        ]);

        Pengeluaran::create([
            'kandang_id' => $request->kandang_id,
            'jenis_produk_id' => $request->jenis_produk_id,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah * $jenisProduks->harga,
        ]);

        return redirect()->route('detail-kandang.show', $request->kandang_id);
    }

    public function destroy($id)
    {
        // delete pengeluaran
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();
        return back();
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // update pengeluaran
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->update([
            'jenis_produk_id' => $request->jenis_produk_id,
            'jumlah' => $request->jumlah,
        ]);
        return back();
    }
}
