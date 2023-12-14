<?php

namespace App\Http\Controllers;

use App\Models\Isian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsianController extends Controller
{
    public function index()
    {
        if (Auth::user()->id_role == 1) {
            $isian = Isian::with('user')->get();
            return view('pages.isian', [
                'isian' => $isian,
            ]);
        } elseif (Auth::user()->id_role == 2) {
            $isian = Isian::with('user')->get();
            return view('pages.isian', [
                'isian' => $isian,
            ]);
        } else {
            $isian = Isian::with('user')->where('id_user', Auth::user()->id)->get();
            return view('pages.isian', [
                'isian' => $isian,
            ]);
        }
    }

    public function detailisian($id)
    {
        if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2) {
            $isian = Isian::with('user')->where('id', $id)->first();
            return view('pages.detail-isian', [
                'isian' => $isian,
            ]);
        } else {
            $isian = Isian::with('user')->where('id', $id)->where('id_user', Auth::user()->id)->first();
            return view('pages.detail-isian', [
                'isian' => $isian,
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required',
            'progres' => 'required',
            'data_dukung' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',

        ], [
            'id_user.required' => 'ID User tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'jam_mulai.required' => 'Jam Mulai tidak boleh kosong',
            'jam_selesai.required' => 'Jam Selesai tidak boleh kosong',
            'kegiatan.required' => 'Kegiatan tidak boleh kosong',
            'progres.required' => 'Progress tidak boleh kosong',
            'data_dukung.file' => 'Data Dukung harus berupa file',
            'data_dukung.mimes' => 'Data Dukung harus berupa file pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
        ]);



        $isian = new Isian;
        $isian->id_user = $request->id_user;
        $isian->tanggal = $request->tanggal;
        $isian->jam_mulai = $request->jam_mulai;
        $isian->jam_selesai = $request->jam_selesai;
        $isian->kegiatan = $request->kegiatan;
        $isian->progres = $request->progres;

        if ($request->link_foto == "") {
            $isian->link_foto = "-";
        } else {
            $isian->link_foto = $request->link_foto;
        }
        if ($request->data_dukung == "") {
            $isian->data_dukung = "-";
        } else {
            $data_dukung = $request->file('data_dukung');
            $nama_data_dukung = time() . "_" . $data_dukung->getClientOriginalName();
            $data_dukung->move(public_path('data_dukung'), $nama_data_dukung);
            $isian->data_dukung = $nama_data_dukung;
        }

        $isian->save();

        return redirect('/isian')->with('store', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kegiatan' => 'required',
            'progres' => 'required',
            'data_dukung' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',

        ], [
            'id_user.required' => 'ID User tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'jam_mulai.required' => 'Jam Mulai tidak boleh kosong',
            'jam_selesai.required' => 'Jam Selesai tidak boleh kosong',
            'kegiatan.required' => 'Kegiatan tidak boleh kosong',
            'progres.required' => 'Progress tidak boleh kosong',
            'data_dukung.file' => 'Data Dukung harus berupa file',
            'data_dukung.mimes' => 'Data Dukung harus berupa file pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',

        ]);

        $isian = Isian::find($id);
        $isian->id_user = $request->id_user;
        $isian->tanggal = $request->tanggal;
        $isian->jam_mulai = $request->jam_mulai;
        $isian->jam_selesai = $request->jam_selesai;
        $isian->kegiatan = $request->kegiatan;
        $isian->progres = $request->progres;
        if ($request->link_foto == "-") {
            $isian->link_foto = "-";
        } elseif ($request->link_foto == "") {
            $isian->link_foto = "-";
        } else {
            $isian->link_foto = $request->link_foto;
        }

        // jika input data dukuung kosong namun data dukung sebelumnya tidak kosong maka data dukung sebelumnya tidak dihapus dari folder data dukung dan data dukung sebelumnya tetap digunakan
        if ($request->data_dukung == "-") {
            $isian->data_dukung = $isian->data_dukung;
        } elseif ($request->data_dukung == "") {
            $isian->data_dukung = $isian->data_dukung;
        } else {
            // jika input data dukung tidak kosong maka data dukung sebelumnya akan dihapus dari folder data dukung dan diganti dengan data dukung yang baru
            if ($isian->data_dukung != "-") {
                unlink(public_path('data_dukung/' . $isian->data_dukung));
            }
            $data_dukung = $request->file('data_dukung');
            $nama_data_dukung = time() . "_" . $data_dukung->getClientOriginalName();
            $data_dukung->move(public_path('data_dukung'), $nama_data_dukung);
            $isian->data_dukung = $nama_data_dukung;
        }

        $isian->save();
        return redirect('/isian')->with('update', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $isian = Isian::find($id);
        // cek data dukung
        if ($isian->data_dukung != "-") {
            unlink(public_path('data_dukung/' . $isian->data_dukung));
        }
        $isian->delete();


        return redirect('/isian')->with('delete', 'Data berhasil dihapus');
    }
}
