<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // tampilkan data
    public function index()
    {
        $users = User::all();
        return view('admin.pengguna', compact('users'));
    }

    // form tambah
    public function create()
    {
        return view('admin.pengguna_create');
    }

    // simpan user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengguna_edit', compact('user'));
    }

    // update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'role' => 'required'
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna diperbarui');
    }

    // hapus user
    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Pengguna dihapus');
    }
}
