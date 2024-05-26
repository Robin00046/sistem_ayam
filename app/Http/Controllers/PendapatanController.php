<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Http\Requests\StorePendapatanRequest;
use App\Http\Requests\UpdatePendapatanRequest;
use Illuminate\Support\Facades\Auth;

class PendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all pendapatan
        $pendapatans = Pendapatan::all();
        return view('pendapatan.index', compact('pendapatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StorePendapatanRequest $request)
    {
        // create new pendapatan

        // dd($request->all());
        Pendapatan::create([
            'id_kandang' => Auth::user()->id,
            'jumlah' => $request->jumlah,
            'total' => $request->jumlah * 19000,
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendapatan $pendapatan)
    {
        // get pendapatan

        return view('pendapatan.show', compact('pendapatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendapatanRequest $request, Pendapatan $pendapatan)
    {
        // update pendapatan

        $pendapatan->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('pendapatan.index')->with('success', 'Pendapatan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendapatan $pendapatan)
    {
        // delete pendapatan
        $pendapatan->delete();
        return back();
    }
}
