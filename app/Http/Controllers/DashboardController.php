<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Isian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->id_role == 1) {
            $user = User::all()->where('id_role', 3);
            $isian = Isian::with('user')->get();
            return view('pages.dashboard', [
                'isian' => $isian,
                'user' => $user,
            ]);
        } elseif (Auth::user()->id_role == 2) {
            $user = User::all()->where('id_role', 3);
            $isian = Isian::with('user')->get();
            return view('pages.dashboard', [
                'isian' => $isian,
                'user' => $user,
            ]);
        } else {
            $user = User::all()->where('id', Auth::user()->id);
            $isian = Isian::with('user')->where('id_user', Auth::user()->id)->get();
            return view('pages.dashboard', [
                'isian' => $isian,
                'user' => $user,
            ]);
        }
    }

    public function report(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $id_user = $request->id_user;

        // ubah format tanggal ke Y-m-d
        $date1 = date('Y-m-d', strtotime($date1));
        $date2 = date('Y-m-d', strtotime($date2));

        if (Auth::user()->id_role == 1 || Auth::user()->id_role == 2) {
            if ($id_user == 0) {
                $user = User::all()->where('id_role', 3);
                $isian = Isian::with('user')->whereBetween('tanggal', [$date1, $date2])->get();
                return view('pages.dashboard', [
                    'isian' => $isian,
                    'user' => $user,
                ]);
            } else {
                $user = User::all()->where('id_role', 3);
                $isian = Isian::with('user')->where('id_user', $id_user)->whereBetween('tanggal', [$date1, $date2])->get();
                return view('pages.dashboard', [
                    'isian' => $isian,
                    'user' => $user,
                ]);
            }
        } else {

            if ($request->date1 == null || $request->date2 == null) {
                $user = User::all()->where('id', Auth::user()->id);
                $isian = Isian::with('user')->where('id_user', Auth::user()->id)->get();
                return view('pages.dashboard', [
                    'isian' => $isian,
                    'user' => $user,
                ]);
            } else {
                $user = User::all()->where('id', Auth::user()->id);
                $isian = Isian::with('user')->where('id_user', Auth::user()->id)->whereBetween('tanggal', [$date1, $date2])->get();
                return view('pages.dashboard', [
                    'isian' => $isian,
                    'user' => $user,
                ]);
            }
        }
    }
}
