<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    const title = 'Dashboard - Yabari Peduli';

    public function admin()
    {
        $jumlahuser = User::all()->where('role', 1)->count();
        return view('admin.home', [
            'title' => self::title,
            'jumlahuser' => $jumlahuser,
        ]);
    }

    public function cust()
    {
        return view('landing.home', [
        ]);
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }

    public function profileadmin()
    {
        return view('admin.profile', [
            'title' => 'Profil - Yabari Peduli',
        ]);
    }

    public function updateprofileadmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email,' . Auth::user()->id,
            'phone_number' => 'required|numeric'
        ]);


        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        $user->save();
        return back()->with('message', 'Profil berhasil diperbarui');
    }

    public function updatepasswordadmin(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:users,email,' . Auth::user()->id,
            'password' => 'required|string|min:8',
            'password_baru' => 'required|string|min:8',
            'konfirmasi_password' => 'required'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (!is_null($request->input('password') & $request->input('password_baru') & $request->input('konfirmasi_password'))) {
            if (Hash::check($request->input('password'), $user->password)) {
                $user->password = Hash::make($request->input('password_baru'));
            } else {
                return redirect()->back()->withInput()->with('salah', 'Password sekarang tidak cocok dengan akun Anda');
            }
        }

        $user->save();
        return back()->with('message', 'Kata sandi berhasil diperbarui');
    }

    public function profileuser()
    {
        return view('landing.profile', [
            'title' => 'Profil - Yabari Peduli',
        ]);
    }

    public function updateprofileuser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email,' . Auth::user()->id,
            'phone_number' => 'required|numeric'
        ]);


        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        $user->save();
        return back()->with('message', 'Profil berhasil diperbarui');
    }

    public function updatepassworduser(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:users,email,' . Auth::user()->id,
            'password' => 'required|string|min:8',
            'password_baru' => 'required|string|min:8',
            'konfirmasi_password' => 'required'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (!is_null($request->input('password') & $request->input('password_baru') & $request->input('konfirmasi_password'))) {
            if (Hash::check($request->input('password'), $user->password)) {
                $user->password = Hash::make($request->input('password_baru'));
            } else {
                return redirect()->back()->withInput()->with('salah', 'Password sekarang tidak cocok dengan akun Anda');
            }
        }

        $user->save();
        return back()->with('message', 'Kata sandi berhasil diperbarui');
    }
}
