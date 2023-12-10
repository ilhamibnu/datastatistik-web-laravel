<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function indexlogin()
    {
        return view('login');
    }

    public function indexregister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:tb_user',
            'password' => 'required',
            'repassword' => 'required|same:password',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'repassword.required' => 'Re-Password tidak boleh kosong',
            'repassword.same' => 'Re-Password tidak sama dengan Password',

        ]);

        $user = new User;
        $user->name = $request->name;
        $user->id_role = 3;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->foto = '';
        $user->save();

        return redirect('/register')->with('success', 'Akun berhasil dibuat');
    }

    public function updateprofil(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:tb_user,email,' . Auth::user()->id,
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'repassword' => 'same:password',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah terdaftar',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar',
            'foto.max' => 'Foto maksimal 2MB',
            'repassword.same' => 'Re-Password tidak sama dengan Password',
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->file('foto')) {
            // cek foto lama
            if ($user->foto != '') {
                unlink(public_path('foto-user/' . $user->foto));
            }

            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->extension();
            $foto->move(public_path('foto-user'), $namaFoto);

            $user->foto = $namaFoto;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->repassword != '') {
            $user->password = bcrypt($request->repassword);
        }
        $user->save();

        return redirect('/dashboard')->with('profilupdate', 'Profile berhasil diubah');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect('/dashboard')->with('success', 'Anda berhasil login');
            } else {
                return redirect('/login')->with('errorpw', 'Password salah');
            }
        } else {
            return redirect('/login')->with('erroremail', 'Email tidak terdaftar');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login')->with('logout', 'Anda berhasil logout');
    }
}
