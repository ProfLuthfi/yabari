<?php

namespace App\Http\Controllers;


use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    const title = 'Yabari Peduli';

    public function index()
    {
        return view('landing.home', [
            'title' => 'Yabari Peduli',
        ]);
    }

    public function kategori($kategori)
    {

    }

    public function cari(Request $request)
    {

    }
}
