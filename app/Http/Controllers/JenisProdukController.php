<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use App\Http\Requests\StoreJenisProdukRequest;
use App\Http\Requests\UpdateJenisProdukRequest;

class JenisProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all jenis produk
        $jenisProduks = JenisProduk::all();
        return view('jenis-produk.index', compact('jenisProduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenisProdukRequest $request)
    {
        //// create new product

        // dd($request->all());
        JenisProduk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect()->route('jenis-produk.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisProduk $jenisProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisProduk $jenisProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisProdukRequest $request, JenisProduk $jenisProduk)
    {
        $jenisprodut = JenisProduk::find($jenisProduk->id);
        $jenisprodut->nama = $request->nama;
        $jenisprodut->harga = $request->harga;
        $jenisprodut->save();

        return redirect()->route('jenis-produk.index')->with('success', 'Jenis Produk updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisProduk $jenisProduk)
    {
        //

        $jenisProduk->delete();
        return redirect()->route('jenis-produk.index')->with('success', 'Jenis Produk deleted successfully');
    }
}
