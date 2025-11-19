<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PembimbingController extends Controller
{
    public function index(){
        $pembimbing = User::where('role', 'pembimbing')->get();
        return view('admin.kelolapembimbing.index', compact('pembimbing'));
    }

    public function create(){
        return view('admin.kelolapembimbing.tambah');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|unique:users,email',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'pembimbing',
        ]); 

        return redirect()->route('admin.pembimbing.store')->with('success', 'pembimbing berhasil dibuat');
    }

    public function edit($id){
        $pembimbing = User::where('role', 'pembimbing')->findOrFail($id);
        return view('admin.kelolapembimbing.edit', compact('pembimbing'));
    }

    public function update(Request $request, User $pembimbing){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email,' . $pembimbing->id,
            'password' => 'nullable|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pembimbing->update($data);

        return redirect()->route('admin.pembimbing.index')->with('success', 'data berhasil diedit');

    }

    public function destroy(User $pembimbing){
        if ($pembimbing->pembimbingSiswa()->count() > 0) {
            return redirect()->route('admin.pembimbing.index')->with('error', 'Pembimbing tidak dapat dihapus karena masih masih memiliki siswa.');
        }
        if($pembimbing->role !== 'pembimbing') {
            return redirect()->route('admin.pembimbing.index')->with('error', 'user bukan pembimbing');

        }

        $pembimbing->delete();

        return redirect()->route('admin.pembimbing.index')->with('success', 'pembimbing berhasil dihapus');

    }
}
