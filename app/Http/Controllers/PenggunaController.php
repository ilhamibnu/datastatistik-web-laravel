<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Isian;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function index()
    {
        if (Auth::user()->id_role == 1) {
            $role = Role::all();
            $pengguna = User::with('role')->get();
            return view('pages.pengguna', [
                'pengguna' => $pengguna,
                'role' => $role,
            ]);
        } elseif (Auth::user()->id_role == 2) {

            $role = Role::all();
            $pengguna = User::with('role')->get();
            return view('pages.pengguna', [
                'pengguna' => $pengguna,
                'role' => $role,
            ]);
        } else {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'id_role' => 'required',
            'email' => 'required|unique:tb_user',
            'password' => 'required',
            'repassword' => 'required|same:password',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'id_role.required' => 'Role tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'repassword.required' => 'Re-Password tidak boleh kosong',
            'repassword.same' => 'Re-Password tidak sama dengan Password',
            'foto.required' => 'Foto tidak boleh kosong',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar',
        ]);

        $foto = $request->file('foto');
        $namaFoto = time() . '.' . $foto->extension();
        $foto->move(public_path('foto-user'), $namaFoto);

        $user = new User;
        $user->name = $request->name;
        $user->id_role = $request->id_role;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->foto = $namaFoto;
        $user->save();

        return redirect('/pengguna')->with('store', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'id_role' => 'required',
            'email' => 'required|unique:tb_user,email,' . $id,
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'repassword' => 'same:password',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'id_role.required' => 'Role tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar',
            'repassword.same' => 'Re-Password tidak sama dengan Password',
        ]);

        $user = User::find($id);

        if ($request->file('foto')) {
            // cek foto lama
            if ($user->foto != '') {
                // Hapus foto lama
                unlink(public_path('foto-user/' . $user->foto));
            }

            // Upload foto baru
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->extension();
            $foto->move(public_path('foto-user'), $namaFoto);
        }

        $user->name = $request->name;
        $user->id_role = $request->id_role;
        $user->email = $request->email;
        if ($request->repassword != '') {
            $user->password = bcrypt($request->repassword);
        }
        if ($request->file('foto')) {
            $user->foto = $namaFoto;
        }
        $user->save();

        return redirect('/pengguna')->with('update', 'Pengguna berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        // cek id user pada tb isian
        $isian = Isian::where('id_user', $id)->get();

        if (count($isian) > 0) {
            return redirect('/pengguna')->with('gagal', 'Pengguna gagal dihapus, karena masih memiliki isian');
        }

        // cek apa ada foto
        if ($user->foto != '') {
            // Hapus foto
            unlink(public_path('foto-user/' . $user->foto));
        }

        $user->delete();

        return redirect('/pengguna')->with('delete', 'Pengguna berhasil dihapus');
    }
}
