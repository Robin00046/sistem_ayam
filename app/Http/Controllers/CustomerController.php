<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\CustomerPasswordMail;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all user
        $users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role')
            ->where('roles.name', 'kandang')
            ->get();
        return view('customers.index', compact('users'));
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
    public function store(Request $request)
    {
        // dd($request->all());
        // tambah customer
        $this->validate($request, [
            'name' => 'required',
            'alamat' => 'required',
            'phone' => 'required|numeric',
        ]);
        $password = "password";
        $user = User::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
            'password' => bcrypt($password),
        ]);
        $user->assignRole('kandang');
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // edit customer 
        $this->validate($request, [
            'name' => 'required',
            'alamat' => 'required|alamat|unique:users,alamat,' . $user->id,
            'phone' => 'required|numeric',
        ]);
        $user->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
        ]);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function ubahStatus($id)
    {
        // update status user
        // dd($id);
        $user = User::find($id);
        $user->update([
            'status' => $user->status == 'active' ? 'inactive' : 'active',
        ]);
        return redirect()->route('customers.index')->with('success', 'Status updated successfully');
    }
}
